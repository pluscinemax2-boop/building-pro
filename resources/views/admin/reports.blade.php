
@extends('layouts.app')
@section('content')
<div class="sticky top-0 z-20 bg-white dark:bg-[#1a222b] px-4 py-3 flex items-center justify-between border-b border-gray-100 dark:border-[#293038] shadow-sm">
	<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Platform Analytics</h2>
	<div class="flex items-center gap-4">
		<button id="notification-btn" type="button" onclick="toggleNotifications()" class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
			<span class="material-symbols-outlined text-[#111418] dark:text-white" style="font-size: 24px;">notifications</span>
			<span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-[#101922]"></span>
		</button>
		<!-- Notification Dropdown -->
		<div id="notification-dropdown" class="hidden absolute right-4 top-16 w-80 max-w-xs bg-white dark:bg-[#192531] rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 animate-fade-in">
			<div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
				<h3 class="text-[#111418] dark:text-white text-base font-bold">Notifications</h3>
				<button onclick="toggleNotifications()" class="text-gray-400 hover:text-primary transition-colors">
					<span class="material-symbols-outlined">close</span>
				</button>
			</div>
			<div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
				@forelse($notifications as $note)
				<div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
					<span class="material-symbols-outlined @if($note['icon']==='report') text-primary bg-blue-50 dark:bg-blue-900/20 @elseif($note['icon']==='payments') text-green-600 bg-green-50 dark:bg-green-900/20 @elseif($note['icon']==='person_add') text-orange-600 bg-orange-50 dark:bg-orange-900/20 @else text-gray-400 bg-gray-100 dark:bg-gray-700 @endif rounded-full p-1">{{ $note['icon'] }}</span>
					<div class="flex-1 min-w-0">
						<p class="text-[#111418] dark:text-white text-sm font-semibold truncate">{{ $note['title'] }}</p>
						<p class="text-[#617589] dark:text-gray-400 text-xs truncate">{{ $note['desc'] }}</p>
						<span class="text-xs text-gray-400">{{ $note['time'] }}</span>
					</div>
				</div>
				@empty
				<div class="text-center text-gray-400 py-6">No new notifications.</div>
				@endforelse
			</div>
		</div>
		<script>
		function toggleNotifications() {
			const dropdown = document.getElementById('notification-dropdown');
			dropdown.classList.toggle('hidden');
			// Optional: close if clicked outside
			if (!dropdown.classList.contains('hidden')) {
				document.addEventListener('mousedown', closeOnClickOutside);
			} else {
				document.removeEventListener('mousedown', closeOnClickOutside);
			}
		}
		function closeOnClickOutside(e) {
			const dropdown = document.getElementById('notification-dropdown');
			const btn = document.getElementById('notification-btn');
			if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
				dropdown.classList.add('hidden');
				document.removeEventListener('mousedown', closeOnClickOutside);
			}
		}
		</script>
	</div>
	
</div>
<!-- Date Filters -->
<form method="GET" action="" class="flex flex-wrap gap-3 p-4 items-center bg-white dark:bg-[#1a222b] border-b border-gray-100 dark:border-[#293038]">
	<label for="range" class="text-sm font-medium text-[#111418] dark:text-white mr-2">Date Range:</label>
	<select id="range" name="range" class="rounded-lg border-gray-300 dark:bg-[#293038] dark:text-white px-3 py-2 focus:ring-primary focus:border-primary">
		<option value="month" @if($range=='month') selected @endif>This Month</option>
		<option value="30days" @if($range=='30days') selected @endif>Last 30 Days</option>
		<option value="custom" @if($range=='custom') selected @endif>Custom Range</option>
	</select>
	<div id="custom-range-fields" class="flex gap-2 items-center" style="display: {{ $range=='custom' ? 'flex' : 'none' }};">
		<input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border-gray-300 dark:bg-[#293038] dark:text-white" placeholder="From">
		<span class="text-gray-500">to</span>
		<input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border-gray-300 dark:bg-[#293038] dark:text-white" placeholder="To">
	</div>
	<button type="submit" class="ml-2 px-4 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary-dark transition">Filter</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const rangeSelect = document.getElementById('range');
	const customFields = document.getElementById('custom-range-fields');
	rangeSelect.addEventListener('change', function() {
		if (this.value === 'custom') {
			customFields.style.display = 'flex';
		} else {
			customFields.style.display = 'none';
		}
	});
});
</script>
<!-- Main Content Area -->
<main class="p-4 space-y-4">
	<!-- KPI Row with growth indicators -->
	<div class="flex gap-4 overflow-x-auto no-scrollbar pb-2 -mx-4 px-4 snap-x">
		<!-- Total Revenue -->
		<div class="snap-start flex min-w-[160px] flex-col gap-2 rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-[#dbe0e6] dark:border-[#293038] shadow-sm">
		   <div class="flex items-center gap-2">
			   <div class="p-1.5 rounded-md bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
				   <span class="material-symbols-outlined text-[20px]">attach_money</span>
			   </div>
			   <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Total Revenue</p>
		   </div>
		   <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">₹{{ $totalRevenue ?? '0' }}</p>
		   <div class="flex items-center gap-1">
			   <span class="material-symbols-outlined text-[#078838] text-[16px]">trending_up</span>
			   <p class="text-[#078838] text-xs font-bold">@if(!is_null($revenueGrowth)) {{ $revenueGrowth > 0 ? '+' : '' }}{{ $revenueGrowth }}% @else N/A @endif</p>
			   <span class="text-gray-400 text-xs ml-1">vs last mo</span>
		   </div>
		</div>
		<!-- Total Societies (Buildings) -->
		<div class="snap-start flex min-w-[160px] flex-col gap-2 rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-[#dbe0e6] dark:border-[#293038] shadow-sm">
		   <div class="flex items-center gap-2">
			   <div class="p-1.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-primary dark:text-blue-400">
				   <span class="material-symbols-outlined text-[20px]">apartment</span>
			   </div>
			   <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Total Societies</p>
		   </div>
		   <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $totalBuildings ?? '0' }}</p>
		   <div class="flex items-center gap-1">
			   <span class="material-symbols-outlined text-[#078838] text-[16px]">trending_up</span>
			   <p class="text-[#078838] text-xs font-bold">@if(!is_null($buildingGrowth)) {{ $buildingGrowth > 0 ? '+' : '' }}{{ $buildingGrowth }}% @else N/A @endif</p>
			   <span class="text-gray-400 text-xs ml-1">vs last mo</span>
		   </div>
		</div>
		<!-- Total Users -->
		<div class="snap-start flex min-w-[160px] flex-col gap-2 rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-[#dbe0e6] dark:border-[#293038] shadow-sm">
			<div class="flex items-center gap-2">
				<div class="p-1.5 rounded-md bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
					<span class="material-symbols-outlined text-[20px]">group</span>
				</div>
				<p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Total Users</p>
			</div>
			<p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $totalUsers ?? '0' }}</p>
			<div class="flex items-center gap-1">
				<span class="material-symbols-outlined text-[#078838] text-[16px]">trending_up</span>
				<p class="text-[#078838] text-xs font-bold">@if(!is_null($userGrowth)) {{ $userGrowth > 0 ? '+' : '' }}{{ $userGrowth }}% @else N/A @endif</p>
				<span class="text-gray-400 text-xs ml-1">vs last mo</span>
			</div>
		</div>
		<!-- Active Subs -->
		<div class="snap-start flex min-w-[160px] flex-col gap-2 rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-[#dbe0e6] dark:border-[#293038] shadow-sm">
			<div class="flex items-center gap-2">
				<div class="p-1.5 rounded-md bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400">
					<span class="material-symbols-outlined text-[20px]">verified</span>
				</div>
				<p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Active Subs</p>
			</div>
			<p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $activeSubscriptions ?? '0' }}</p>
		</div>
	</div>
	<!-- Revenue Trends Chart -->
	<div class="flex flex-col gap-4 rounded-xl bg-surface-light dark:bg-surface-dark border border-[#dbe0e6] dark:border-[#293038] p-5 shadow-sm">
		<div class="flex justify-between items-start">
			<div class="flex flex-col gap-1">
				<p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Revenue Trends</p>
				<p class="text-[#111418] dark:text-white tracking-tight text-[28px] font-bold leading-tight truncate">₹{{ $totalRevenue ?? '0' }}</p>
			</div>
			<button class="text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 p-2 rounded-full transition-colors">
				<span class="material-symbols-outlined text-[20px]">more_horiz</span>
			</button>
		</div>
		<div class="flex gap-2 items-center">
			<span class="px-2 py-1 rounded bg-green-100 dark:bg-green-900/30 text-[#078838] dark:text-green-400 text-xs font-bold">+12%</span>
			<p class="text-[#617589] dark:text-gray-500 text-xs font-normal">than previous month</p>
		</div>
		<div class="flex min-h-[180px] flex-1 flex-col gap-4 mt-2">
			<!-- SVG Chart Placeholder -->
			<canvas id="revenueTrendsChart" height="120"></canvas>
			<!-- Chart.js CDN -->
			<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
			<script>
			// Revenue trend data from backend
			const revenueLabels = @json($revenueLabels ?? []);
			const revenueData = @json($revenueData ?? []);

			const ctx = document.getElementById('revenueTrendsChart').getContext('2d');
			const revenueChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: revenueLabels,
					datasets: [{
						label: 'Revenue',
						data: revenueData,
						fill: true,
						backgroundColor: 'rgba(19, 127, 236, 0.15)',
						borderColor: '#137fec',
						tension: 0.4,
						pointBackgroundColor: '#137fec',
						pointBorderColor: '#fff',
						pointRadius: 4,
						pointHoverRadius: 6,
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: { display: false },
						tooltip: { mode: 'index', intersect: false }
					},
					scales: {
						x: {
							grid: { display: false },
							ticks: { color: '#617589', font: { size: 12, weight: 'bold' } }
						},
						y: {
							grid: { color: '#f0f2f4' },
							ticks: { color: '#617589', font: { size: 12 } },
							beginAtZero: true
						}
					}
				}
			});
			</script>
			<div class="flex justify-between border-t border-[#f0f2f4] dark:border-[#293038] pt-3 mt-2">
				<p class="text-[#617589] text-xs font-medium">Jan</p>
				<p class="text-[#617589] text-xs font-medium">Feb</p>
				<p class="text-[#617589] text-xs font-medium">Mar</p>
				<p class="text-[#617589] text-xs font-medium">Apr</p>
				<p class="text-[#617589] text-xs font-medium">May</p>
				<p class="text-[#111418] dark:text-white text-xs font-bold">Jun</p>
			</div>
		</div>
	</div>
	<!-- New Buildings Bar Chart -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		<div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] dark:border-[#293038] bg-surface-light dark:bg-surface-dark p-5 shadow-sm">
			<div class="flex flex-col gap-2">
				<div class="flex justify-between items-center mb-1">
					<div>
						<p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">New Buildings</p>
						<p class="text-[#111418] dark:text-white tracking-tight text-2xl font-bold leading-tight">{{ $newBuildings ?? '0' }} New</p>
					</div>
					<div class="flex items-center gap-2">
						<button id="scrollLeftBtn" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800"><span class="material-symbols-outlined">chevron_left</span></button>

						<button id="scrollRightBtn" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800"><span class="material-symbols-outlined">chevron_right</span></button>
					</div>
				</div>
				<div class="flex items-center gap-2 mb-1">
					<label for="buildingYearSelect" class="text-xs text-[#617589] dark:text-gray-400 font-medium">Year:</label>
					<select id="buildingYearSelect" class="rounded border-gray-300 dark:bg-[#293038] dark:text-white text-xs "></select>
					<select id="buildingViewMode" class="rounded border-gray-300 dark:bg-[#293038] dark:text-white text-xs ">
							<option value="week">Week</option>
							<option value="month">Month</option>
						</select>
				</div>
			</div>
			<div class="flex gap-1 mb-4">
				<p class="text-[#617589] dark:text-gray-500 text-xs font-normal">This Quarter</p>
				<p class="text-[#078838] text-xs font-medium">+4%</p>
			</div>
			<div class="h-[140px] w-full relative">
				<canvas id="newBuildingsBarChart" height="120"></canvas>
			</div>
			<script>
			// New Buildings bar chart data from backend
			const buildingLabelsWeekAll = @json($buildingLabels ?? []);
			const buildingDataWeekAll = @json($buildingData ?? []);
			const buildingLabelsMonthAll = @json($buildingLabelsMonth ?? []);
			const buildingDataMonthAll = @json($buildingDataMonth ?? []);

			// Extract years from month labels (e.g. "Jan 2025")
			const allYears = Array.from(new Set(buildingLabelsMonthAll.map(lbl => lbl.split(' ')[1]))).sort();
			let selectedYear = allYears.length ? allYears[allYears.length-1] : new Date().getFullYear().toString();

			// Populate year select
			const yearSelect = document.getElementById('buildingYearSelect');
			yearSelect.innerHTML = allYears.map(y => `<option value="${y}">${y}</option>`).join('');
			yearSelect.value = selectedYear;

			let currentView = 'week';
			let chartStart = 0;
			const chartWindow = 12; // Show 12 bars at a time

			const ctxBuildings = document.getElementById('newBuildingsBarChart').getContext('2d');
			let newBuildingsBarChart = null;

			function filterByYear(labels, data, year, isMonth) {
			  if (isMonth) {
				const filtered = labels.map((lbl, i) => ({lbl, val: data[i]})).filter(x => x.lbl.endsWith(year));
				return {
				  labels: filtered.map(x => x.lbl),
				  data: filtered.map(x => x.val)
				};
			  } else {
				// For week, try to filter by year in label (Wxx) and data (not perfect, but works if week data is for one year)
				// If week labels are for multiple years, need backend support
				return { labels, data };
			  }
			}

			function renderBuildingsChart(view, start=0, year=selectedYear) {
				let labels, data;
				if (view === 'month') {
				  const filtered = filterByYear(buildingLabelsMonthAll, buildingDataMonthAll, year, true);
				  labels = filtered.labels;
				  data = filtered.data;
				} else {
				  // For week, show all for now (or filter if backend provides year info)
				  labels = buildingLabelsWeekAll;
				  data = buildingDataWeekAll;
				}
				const end = Math.min(start + chartWindow, labels.length);
				const slicedLabels = labels.slice(start, end);
				const slicedData = data.slice(start, end);
				if (newBuildingsBarChart) newBuildingsBarChart.destroy();
				newBuildingsBarChart = new Chart(ctxBuildings, {
					type: 'bar',
					data: {
						labels: slicedLabels,
						datasets: [{
							label: 'New Buildings',
							data: slicedData,
							backgroundColor: 'rgba(19, 127, 236, 0.7)',
							borderRadius: 6,
							maxBarThickness: 32,
						}]
					},
					options: {
						responsive: true,
						plugins: {
							legend: { display: false },
							tooltip: { mode: 'index', intersect: false }
						},
						scales: {
							x: {
								grid: { display: false },
								ticks: { color: '#617589', font: { size: 12, weight: 'bold' } }
							},
							y: {
								grid: { color: '#f0f2f4' },
								ticks: { color: '#617589', font: { size: 12 } },
								beginAtZero: true
							}
						}
					}
				});
			}

			document.getElementById('buildingViewMode').addEventListener('change', function(e) {
				currentView = e.target.value;
				chartStart = 0;
				renderBuildingsChart(currentView, chartStart, selectedYear);
			});
			document.getElementById('scrollLeftBtn').addEventListener('click', function() {
				chartStart = Math.max(0, chartStart - chartWindow);
				renderBuildingsChart(currentView, chartStart, selectedYear);
			});
			document.getElementById('scrollRightBtn').addEventListener('click', function() {
				let labels;
				if (currentView === 'month') {
				  const filtered = filterByYear(buildingLabelsMonthAll, buildingDataMonthAll, selectedYear, true);
				  labels = filtered.labels;
				} else {
				  labels = buildingLabelsWeekAll;
				}
				if (chartStart + chartWindow < labels.length) {
					chartStart += chartWindow;
					renderBuildingsChart(currentView, chartStart, selectedYear);
				}
			});
			yearSelect.addEventListener('change', function(e) {
				selectedYear = e.target.value;
				chartStart = 0;
				renderBuildingsChart(currentView, chartStart, selectedYear);
			});

			// Initial render: show latest 12 bars for selected year
			function getInitialStart(labels) {
				return Math.max(0, labels.length - chartWindow);
			}
			let initialLabels = filterByYear(buildingLabelsMonthAll, buildingDataMonthAll, selectedYear, true).labels;
			chartStart = getInitialStart(initialLabels);
			renderBuildingsChart(currentView, chartStart, selectedYear);
			</script>
		</div>
		<!-- Churn Rate (Donut Chart) -->
		<div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] dark:border-[#293038] bg-surface-light dark:bg-surface-dark p-5 shadow-sm relative overflow-hidden">
			<div class="flex justify-between items-start mb-2 z-10">
				<div>
					<p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Churn Rate</p>
				</div>
				<span class="material-symbols-outlined text-[#617589] dark:text-gray-500 text-[20px]">pie_chart</span>
			</div>
			<div class="flex items-center justify-center py-2 z-10">
				<div class="relative w-32 h-32">
					<svg class="w-full h-full transform -rotate-90">
						<circle class="text-[#f0f2f4] dark:text-[#293038]" cx="64" cy="64" fill="transparent" r="56" stroke="currentColor" stroke-width="12"></circle>
						<circle cx="64" cy="64" fill="transparent" r="56" stroke="#ef4444" stroke-dasharray="351.85" stroke-dashoffset="330" stroke-linecap="round" stroke-width="12"></circle>
					</svg>
					<div class="absolute inset-0 flex flex-col items-center justify-center">
						<span class="text-2xl font-bold text-[#111418] dark:text-white">
							@if(!is_null($churnRate))
								{{ $churnRate }}%
								<span class="ml-2 text-base font-normal text-[#617589]">Churned</span>
								<br>
								<span class="text-lg font-semibold text-green-600">
									{{ 100 - $churnRate }}%
								</span>
								<span class="ml-1 text-base font-normal text-[#617589]">Retained</span>
							@else
								N/A
							@endif
						</span>
						<span class="text-[10px] text-[#617589] font-medium uppercase tracking-wide">Lost</span>
					</div>
				</div>
			</div>
			<div class="flex justify-center gap-6 mt-2 z-10">
				<div class="flex items-center gap-2">
					<span class="w-2 h-2 rounded-full bg-[#ef4444]"></span>
					<span class="text-xs text-[#617589] font-medium">Churned</span>
				</div>
				<div class="flex items-center gap-2">
					<span class="w-2 h-2 rounded-full bg-[#f0f2f4] dark:bg-[#293038] border border-gray-300 dark:border-gray-600"></span>
					<span class="text-xs text-[#617589] font-medium">Retained</span>
				</div>
			</div>
		</div>
	</div>
	<!-- Recent Activity List -->
	<div class="rounded-xl border border-[#dbe0e6] dark:border-[#293038] bg-surface-light dark:bg-surface-dark shadow-sm mt-4">
		<div class="flex items-center justify-between p-4 border-b border-[#f0f2f4] dark:border-[#293038]">
			<h3 class="text-[#111418] dark:text-white text-base font-bold">Recent Activity</h3>
			<a href="{{ route('admin.recent.activities') }}" class="text-primary text-sm font-medium hover:underline">View All</a>
		</div>
		<div class="flex flex-col">
			@forelse($recentActivities as $activity)
				<div class="flex items-center gap-3 p-4 border-b border-[#f0f2f4] dark:border-[#293038] last:border-0 hover:bg-gray-50 dark:hover:bg-[#202932] transition-colors">
					<div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
						@if($activity['type']==='payment-success') bg-blue-100 dark:bg-blue-900/30
						@elseif($activity['type']==='payment-failed') bg-orange-100 dark:bg-orange-900/30
						@elseif($activity['type']==='new-building') bg-green-100 dark:bg-green-900/30
						@else bg-gray-200 dark:bg-gray-700 @endif">
						<span class="material-symbols-outlined text-[20px] 
							@if($activity['type']==='payment-success') text-primary
							@elseif($activity['type']==='payment-failed') text-orange-600 dark:text-orange-400
							@elseif($activity['type']==='new-building') text-green-600 dark:text-green-400
							@else text-gray-500 @endif">
							@if($activity['type']==='payment-success') verified
							@elseif($activity['type']==='payment-failed') warning
							@elseif($activity['type']==='new-building') add_business
							@else info @endif
						</span>
					</div>
					<div class="flex-1 min-w-0">
						<p class="text-sm font-medium text-[#111418] dark:text-white truncate">{{ $activity['title'] }}</p>
						<p class="text-xs text-[#617589] dark:text-gray-400 truncate">{{ $activity['desc'] }}</p>
					</div>
					<p class="text-xs text-[#617589] font-medium whitespace-nowrap">{{ $activity['time']->diffForHumans() }}</p>
				</div>
			@empty
				<div class="p-4 text-center text-xs text-gray-400">No recent activity.</div>
			@endforelse
		</div>
	</div>
	<!-- Add more analytics sections here as needed -->
</main>
<!-- Spacer for content to not be hidden behind bottom nav -->
<div class="h-8"></div>
<!-- Bottom Navigation Bar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-[#192531] border-t border-gray-200 dark:border-gray-700 pb-safe pt-2 px-2 max-w-md mx-auto">
	<div class="flex items-center justify-around pb-2">
		<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">dashboard</span>
			<span class="text-[10px] font-medium">Home</span>
		</a>
		<a href="{{ route('admin.building-management') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">apartment</span>
			<span class="text-[10px] font-medium">Buildings</span>
		</a>
		<a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">group</span>
			<span class="text-[10px] font-medium">Users</span>
		</a>
		<a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-primary group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform filled" style="font-variation-settings: 'FILL' 1;">bar_chart</span>
			<span class="text-[10px] font-medium">Reports</span>
		</a>
		<button type="button" onclick="document.getElementById('settings-overlay').classList.remove('hidden')" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">settings</span>
			<span class="text-[10px] font-medium">Settings</span>
		</button>
	</div>
</div>
@endsection
