<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show Building Profile Page
     */
    public function show()
    {
        $user = Auth::user();
        $building = $user->building;

        // Building information with fallbacks
        $buildingName = $building->name ?? 'Building';
        $buildingAddress = $building->address ?? '';
        $buildingImage = $building->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuDv9WLoiPx5ptjjbJSwxvKFZfdUXosyXv5VMQoMOj2G8Z0fVEqQ9zD5oVJBfwMmPvLJuPVJjnvK4hDcTQE_gBDeby1vZnqUzU2QpBbb96PfKhHErjB6zuOIFWaTb7at4KBZLyaVCGiVC57CFjTfwYT6P1Rom1R2ABY-y4CcsREDsP_gt7nilwnyrnSmnUBd8GebmjopZf4ZM5a0T3gXU-QUHuXviOVM6j_xygJPJbiKa5GPwj2rUgxsuTfduJOsnVMJydCEPqLTbLoO';
        
        $statusIcon = 'verified';
        $statusBgClass = 'bg-emerald-50 dark:bg-emerald-900/20';
        $statusTextClass = 'text-emerald-700 dark:text-emerald-400';
        $statusBorderClass = 'border-emerald-100 dark:border-emerald-800';
        $statusPingClass = 'bg-emerald-400 opacity-75';
        $statusDotClass = 'bg-emerald-500';
        $buildingStatus = $building->status ?? 'Active';
        
        $city = $building->city ?? '';
        $state = $building->state ?? '';
        $zip = $building->zip ?? '';
        $emergencyPhone = $building->emergency_phone ?? '';
        $totalFloors = $building->total_floors ?? '';
        $totalFlats = $building->total_flats ?? '';
        $managerName = $building->manager_name ?? '';

        $generalInfo = [
            ['icon' => 'location_city', 'label' => 'City', 'value' => $city],
            ['icon' => 'map', 'label' => 'State', 'value' => $state],
            ['icon' => 'pin_drop', 'label' => 'Zip Code', 'value' => $zip],
        ];
        $capacityInfo = [
            ['icon' => 'stairs', 'label' => 'Total Floors', 'value' => $totalFloors],
            ['icon' => 'door_front', 'label' => 'Total Flats', 'value' => $totalFlats],
        ];
        $contactInfo = [
            ['icon' => 'person', 'label' => 'Manager', 'value' => $managerName],
            ['icon' => 'phone_in_talk', 'label' => 'Emergency', 'value' => $emergencyPhone, 'class' => 'text-primary group-hover/phone:underline cursor-pointer'],
        ];

        return view('building-admin.building-profile', [
            'pageTitle' => 'Building Profile',
            'buildingName' => $buildingName,
            'buildingAddress' => $buildingAddress,
            'buildingImage' => $buildingImage,
            'buildingImageAlt' => $buildingName,
            'statusIcon' => $statusIcon,
            'statusBgClass' => $statusBgClass,
            'statusTextClass' => $statusTextClass,
            'statusBorderClass' => $statusBorderClass,
            'statusPingClass' => $statusPingClass,
            'statusDotClass' => $statusDotClass,
            'buildingStatus' => $buildingStatus,
            'generalInfo' => $generalInfo,
            'capacityInfo' => $capacityInfo,
            'contactInfo' => $contactInfo,
            'editButtonIcon' => 'edit_document',
            'editButtonText' => 'Edit Information',
        ]);
    }

    /**
     * Show Admin User Profile & Security
     */
    public function adminProfile()
    {
        $admin = Auth::user();
        return view('building-admin.person-profile-and-security', compact('admin'));
    }

    /**
     * Edit Admin User Profile Form
     */
    public function edit()
    {
        $admin = Auth::user();
        return view('building-admin.profile.edit', compact('admin'));
    }

    /**
     * Update Admin User Profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $admin = Auth::user();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        return redirect()->route('building-admin.admin-profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show Password Change Form
     */
    public function passwordForm()
    {
        return view('building-admin.profile.password');
    }

    /**
     * Update Admin User Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('building-admin.admin-profile')->with('success', 'Password updated successfully!');
    }

    /**
     * Update Admin User Avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $user = Auth::user();
        $file = $request->file('avatar');
        $path = $file->store('user-avatars', 'public');

        // Delete old avatar if exists
        if ($user->avatar && !str_contains($user->avatar, 'lh3.googleusercontent.com')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar));
        }

        $user->avatar = '/storage/' . $path;
        $user->save();

        return redirect()->route('building-admin.admin-profile')->with('success', 'Profile image updated!');
    }

    /**
     * Show 2FA Setup Form
     */
    public function twoFactorSetup()
    {
        $user = Auth::user();
        
        // Generate new secret if not already generated
        if (!$user->two_factor_secret) {
            $secret = $this->generateSecret();
            $user->two_factor_secret = $secret;
            $user->save();
        }

        $secret = $user->two_factor_secret;
        $qrCodeUrl = $this->generateQrCode($user->email, $secret);
        $backupCodes = $this->generateBackupCodes();

        return view('building-admin.profile.two-factor-setup', compact('secret', 'qrCodeUrl', 'backupCodes', 'user'));
    }

    /**
     * Verify 2FA Setup
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();
        $secret = $user->two_factor_secret;

        if ($this->verifyCode($request->code, $secret)) {
            $backupCodes = $this->generateBackupCodes();
            $user->two_factor_enabled = true;
            $user->two_factor_backup_codes = json_encode($backupCodes);
            $user->save();

            return redirect()->route('building-admin.admin-profile')->with('success', 'Two-Factor Authentication enabled successfully! Save your backup codes in a safe place.');
        }

        return back()->withErrors(['code' => 'Invalid verification code. Please try again.']);
    }

    /**
     * Disable 2FA
     */
    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->two_factor_backup_codes = null;
        $user->save();

        return redirect()->route('building-admin.admin-profile')->with('success', 'Two-Factor Authentication has been disabled.');
    }

    /**
     * Generate TOTP Secret (Base32 encoded)
     */
    private function generateSecret()
    {
        // Generate 20 random bytes for 160-bit secret
        $randomBytes = random_bytes(20);
        
        // Encode to base32
        return $this->base32Encode($randomBytes);
    }

    /**
     * Encode bytes to Base32
     */
    private function base32Encode($input)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;

        for ($i = 0; $i < strlen($input); $i++) {
            $v = ($v << 8) | ord($input[$i]);
            $vbits += 8;
            
            while ($vbits >= 5) {
                $vbits -= 5;
                $output .= $alphabet[($v >> $vbits) & 31];
            }
        }

        if ($vbits > 0) {
            $output .= $alphabet[($v << (5 - $vbits)) & 31];
        }

        // Pad to multiple of 8
        while (strlen($output) % 8 !== 0) {
            $output .= '=';
        }

        return $output;
    }

    /**
     * Generate QR Code URL
     */
    private function generateQrCode($email, $secret)
    {
        $company = 'Building Manager Pro';
        $encodedSecret = rawurlencode($secret);
        $encodedEmail = rawurlencode($email);
        
        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . 
               rawurlencode("otpauth://totp/{$company}:{$encodedEmail}?secret={$secret}&issuer={$company}");
    }

    /**
     * Verify TOTP Code
     */
    private function verifyCode($code, $secret)
    {
        // Get current time and check multiple time windows for clock drift
        $currentTime = floor(time() / 30);
        
        // Check current, previous, and next time windows
        for ($i = -1; $i <= 1; $i++) {
            $timeWindow = $currentTime + $i;
            $expectedCode = $this->generateTOTPCode($secret, $timeWindow);
            
            if ((string)$code === (string)$expectedCode) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Generate TOTP Code using standard algorithm
     */
    private function generateTOTPCode($secret, $time = null)
    {
        if ($time === null) {
            $time = floor(time() / 30);
        }

        // Decode the base32 secret
        $secretBinary = $this->base32Decode($secret);
        
        // Create the time counter (8 bytes, big-endian)
        $counter = pack('J', $time);
        
        // Generate HMAC-SHA1
        $hmac = hash_hmac('sha1', $counter, $secretBinary, true);
        
        // Dynamic truncation
        $offset = ord($hmac[19]) & 0x0f;
        $code = (
            ((ord($hmac[$offset]) & 0x7f) << 24) |
            ((ord($hmac[$offset + 1]) & 0xff) << 16) |
            ((ord($hmac[$offset + 2]) & 0xff) << 8) |
            (ord($hmac[$offset + 3]) & 0xff)
        );
        
        // Get 6-digit code
        $otp = $code % 1000000;
        
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Decode Base32 String
     */
    private function base32Decode($input)
    {
        $input = strtoupper($input);
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;

        for ($i = 0; $i < strlen($input); $i++) {
            $c = $input[$i];
            if ($c === '=') {
                break;
            }
            
            $pos = strpos($alphabet, $c);
            if ($pos === false) {
                continue;
            }
            
            $v = ($v << 5) | $pos;
            $vbits += 5;
            
            if ($vbits >= 8) {
                $vbits -= 8;
                $output .= chr(($v >> $vbits) & 0xff);
            }
        }

        return $output;
    }

    /**
     * Generate Backup Codes
     */
    private function generateBackupCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4))) . '-' . strtoupper(bin2hex(random_bytes(4)));
        }
        return $codes;
    }
}


