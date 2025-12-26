<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File a Complaint - Stitch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">File a Complaint</h1>
                <p class="text-gray-600 text-sm mt-2">Report any issue or concern in your apartment</p>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-700 font-medium">Please correct the following errors:</p>
                <ul class="text-red-600 text-sm mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ url('/resident/complaints') }}" class="space-y-6">
                @csrf

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Complaint Category *</label>
                    <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">Select a category</option>
                        <option value="maintenance">Maintenance Issue</option>
                        <option value="noise">Noise Complaint</option>
                        <option value="water">Water/Plumbing</option>
                        <option value="electric">Electrical</option>
                        <option value="cleanliness">Cleanliness</option>
                        <option value="parking">Parking Issue</option>
                        <option value="security">Security Concern</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Brief title of your complaint">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Description *</label>
                    <textarea name="description" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Describe the issue in detail">{{ old('description') }}</textarea>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Priority Level</label>
                    <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <!-- Photo Upload (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Attach Photo (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-500 transition cursor-pointer">
                        <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input">
                        <label for="photo-input" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-900 font-medium">Click to upload or drag and drop</p>
                            <p class="text-gray-600 text-sm">PNG, JPG, GIF up to 10MB</p>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Complaint
                    </button>
                    <a href="/resident/complaints" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg text-center transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-blue-700 text-sm"><i class="fas fa-info-circle mr-2"></i>Your complaint will be reviewed by the building management within 24 hours.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
