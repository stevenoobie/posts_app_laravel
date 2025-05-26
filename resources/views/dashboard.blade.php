<x-layout title="Dashboard">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h2 class="text-lg font-semibold mb-2">Publishing Success Rate</h2>
            <div class="text-4xl font-bold text-green-600 mb-2">{{ $successRate }}%</div>
            <div class="text-gray-600">Published: <span class="font-semibold">{{ $publishedCount }}</span> &nbsp;|&nbsp; Scheduled: <span class="font-semibold">{{ $scheduledCount }}</span></div>
            <canvas id="scheduledVsPublishedChart" class="mt-4"></canvas>
        </div>
        <div>
            <h2 class="text-lg font-semibold mb-2">Posts Created (Last 7 Days)</h2>
            <table class="w-full text-sm border mb-4">
                <thead>
                    <tr><th class="border px-2 py-1">Date</th><th class="border px-2 py-1">Count</th></tr>
                </thead>
                <tbody>
                    @foreach($postsLast7Days as $row)
                        <tr>
                            <td class="border px-2 py-1">{{ $row->date }}</td>
                            <td class="border px-2 py-1">{{ $row->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="postsLast7DaysChart"></canvas>
        </div>
        <div>
            <h2 class="text-lg font-semibold mb-2">Users Registered (Last 7 Days)</h2>
            <table class="w-full text-sm border mb-4">
                <thead>
                    <tr><th class="border px-2 py-1">Date</th><th class="border px-2 py-1">Count</th></tr>
                </thead>
                <tbody>
                    @foreach($usersLast7Days as $row)
                        <tr>
                            <td class="border px-2 py-1">{{ $row->date }}</td>
                            <td class="border px-2 py-1">{{ $row->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="usersLast7DaysChart"></canvas>
        </div>
        <div>
            <h2 class="text-lg font-semibold mb-2">Posts Per Platform</h2>
            <table class="w-full text-sm border mb-4">
                <thead>
                    <tr><th class="border px-2 py-1">Platform</th><th class="border px-2 py-1">Posts</th></tr>
                </thead>
                <tbody>
                    @foreach($postsPerPlatform as $platform)
                        <tr>
                            <td class="border px-2 py-1">{{ $platform->name }}</td>
                            <td class="border px-2 py-1">{{ $platform->posts_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="postsPerPlatformChart"></canvas>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Posts Last 7 Days
        const postsLast7DaysLabels = @json($postsLast7Days->pluck('date'));
        const postsLast7DaysData = @json($postsLast7Days->pluck('count'));
        new Chart(document.getElementById('postsLast7DaysChart'), {
            type: 'bar',
            data: {
                labels: postsLast7DaysLabels,
                datasets: [{
                    label: 'Posts',
                    data: postsLast7DaysData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });

        // Users Last 7 Days
        const usersLast7DaysLabels = @json($usersLast7Days->pluck('date'));
        const usersLast7DaysData = @json($usersLast7Days->pluck('count'));
        new Chart(document.getElementById('usersLast7DaysChart'), {
            type: 'bar',
            data: {
                labels: usersLast7DaysLabels,
                datasets: [{
                    label: 'Users',
                    data: usersLast7DaysData,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });

        // Posts Per Platform
        const postsPerPlatformLabels = @json($postsPerPlatform->pluck('name'));
        const postsPerPlatformData = @json($postsPerPlatform->pluck('posts_count'));
        new Chart(document.getElementById('postsPerPlatformChart'), {
            type: 'pie',
            data: {
                labels: postsPerPlatformLabels,
                datasets: [{
                    label: 'Posts',
                    data: postsPerPlatformData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {responsive: true}
        });

        // Scheduled vs Published Chart
        new Chart(document.getElementById('scheduledVsPublishedChart'), {
            type: 'doughnut',
            data: {
                labels: ['Published', 'Scheduled'],
                datasets: [{
                    data: [{{ $publishedCount }}, {{ $scheduledCount }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(59, 130, 246, 0.7)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {responsive: true}
        });
    </script>
</x-layout>
