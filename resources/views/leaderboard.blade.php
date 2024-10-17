@component('layout')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Leaderboard</h1>
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <label for="time-period" class="mr-2 text-gray-700">Sort by:</label>
            <select id="time-period" class="bg-white border border-gray-300 rounded px-3 py-2">
                <option value="7days">Last 7 Days</option>
                <option value="1month">Last 1 Month</option>
                <option value="6months">Last 6 Months</option>
                <option value="1year">Last 1 Year</option>
            </select>
        </div>
    </div>
    
    <!-- Leaderboard Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Picture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Example row 1 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="https://via.placeholder.com/50" alt="Profile Picture" class="w-12 h-12 rounded-full">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1200</td>
                </tr>
                <!-- Example row 2 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="https://via.placeholder.com/50" alt="Profile Picture" class="w-12 h-12 rounded-full">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jane Smith</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1100</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
    
    <!-- Your Rank Section -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Your Rank</h2>
        <div class="flex items-center space-x-4">
            <!-- Rank -->
            <div class="text-xl font-bold text-gray-900">
                15
            </div>
            <!-- Profile Picture -->
            <div>
                <img src="https://via.placeholder.com/50" alt="Profile Picture" class="w-12 h-12 rounded-full">
            </div>
            <!-- Name and Points -->
            <div>
                <div class="text-lg font-medium text-gray-700">Your Name</div>
                <div class="text-sm text-gray-500">850 points</div>
            </div>
        </div>
    </div>

</div>
@endcomponent