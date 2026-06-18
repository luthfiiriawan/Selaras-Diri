<?php

namespace App\Helpers;

class Google2FA
{
    /**
     * Generate a random 16-character Base32 secret key.
     */
    public static function generateSecretKey(int $length = 16): string
    {
        $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $base32chars[random_int(0, 31)];
        }
        return $secret;
    }

    /**
     * Decode a Base32 encoded string into binary data.
     */
    public static function base32Decode(string $base32): string|bool
    {
        $base32 = strtoupper($base32);
        if (!preg_match('/^[A-Z2-7=]+$/', $base32)) {
            return false;
        }

        $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $base32charsFlipped = array_flip(str_split($base32chars));

        $paddingCharCount = substr_count($base32, '=');
        $allowedPaddingCounts = [0, 1, 3, 4, 6];
        if (!in_array($paddingCharCount, $allowedPaddingCounts)) {
            return false;
        }

        $base32 = str_replace('=', '', $base32);
        $binaryString = '';
        foreach (str_split($base32) as $char) {
            if (!isset($base32charsFlipped[$char])) {
                return false;
            }
            $binaryString .= str_pad(decbin($base32charsFlipped[$char]), 5, '0', STR_PAD_LEFT);
        }

        $eightBitBytes = str_split($binaryString, 8);
        $decoded = '';
        foreach ($eightBitBytes as $byte) {
            if (strlen($byte) === 8) {
                $decoded .= chr(bindec($byte));
            }
        }
        return $decoded;
    }

    /**
     * Verify a 6-digit TOTP code against a secret key within a discrepancy window.
     */
    public static function verifyCode(string $secret, string $code, int $discrepancy = 1): bool
    {
        $decodedSecret = self::base32Decode($secret);
        if ($decodedSecret === false) {
            return false;
        }

        // Get current time slice (30-second window)
        $currentTimeSlice = floor(time() / 30);

        // Check code against current time slice and discrepancy window
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $timeSlice = $currentTimeSlice + $i;

            // Pack time slice into binary string (8 bytes)
            $timeBinary = pack('N*', 0) . pack('N*', $timeSlice);

            // Calculate HMAC-SHA1
            $hash = hash_hmac('sha1', $timeBinary, $decodedSecret, true);

            // Dynamic truncation
            $offset = ord($hash[19]) & 0xf;
            $otp = (
                (ord($hash[$offset]) & 0x7f) << 24 |
                (ord($hash[$offset+1]) & 0xff) << 16 |
                (ord($hash[$offset+2]) & 0xff) << 8 |
                (ord($hash[$offset+3]) & 0xff)
            ) % 1000000;

            // Format to 6 digits
            $formattedOtp = str_pad((string)$otp, 6, '0', STR_PAD_LEFT);

            if (hash_equals($formattedOtp, trim($code))) {
                return true;
            }
        }

        return false;
    }
}
