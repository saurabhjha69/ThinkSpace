@component('layout')
    <div class="container mx-auto py-8">
        <!-- Total Categories Section -->
        <section class="mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Total Categories</h2>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Category</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Courses</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Created At</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-b">
                                <td class="py-3 px-4 flex gap-2">{{$category->name}}<span
                                        class="bg-yellow-400 text-white rounded-full px-4 text-xs">new</span></td>
                                <td class="py-3 px-4">{{$category->courses->count()}}</td>
                                <td class="py-3 px-4">{{$category->created_at}}</td>
                                <td class="py-3 px-4">{{$category->updated_at}}</td>
                            </tr>
                        @endforeach
                        <!-- Additional categories can be added here -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Add/Delete Categories Section -->
        <section class="mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Categories</h2>
            <div class="flex space-x-4">
                <!-- Add Category -->
                <div class="w-1/2 bg-white shadow-md rounded-lg p-6">
                    <form action="/category/create" method="post">
                        @csrf
                        <h3 class="text-lg font-semibold mb-4">Add New Category</h3>
                        <input type="text" name="category" placeholder="Category Name"
                            class="w-full border rounded-md py-2 px-4 mb-4">
                            @error('category')
                                <p class="text-xs text-red-600">{{$message}}</p>
                            @enderror
                        <label class="flex items-center mb-4">
                            <input type="checkbox" class="mr-2"> Notify users about new category
                        </label>
                        <input type="submit" value="Add Category"
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                    </form>
                </div>

                <!-- Delete Category -->
                <div class="w-1/2 bg-white shadow-md rounded-lg p-6">
                    <form action="/category/del" method="post">
                        @csrf
                        @method('DELETE')
                    <h3 class="text-lg font-semibold mb-4">Delete Category</h3>
                    <select name="category" class="w-full border rounded-md py-2 px-4 mb-4">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{ $category->name }}</option>
                        @endforeach
                        <!-- More categories -->
                    </select>
                    <input type="submit" class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600" value="Delete Category">
                </form>
                </div>
            </div>
        </section>

        <!-- Analytics Section -->
        <section>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Top Performing Categories</h2>
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Analytics</h3>
                    <select class="border rounded-md py-2 px-4">
                        <option value="search">By Searching</option>
                        <option value="courses">By Courses</option>
                        <option value="purchase">By Purchase</option>
                    </select>
                </div>
                <!-- Chart Placeholder -->
                <div id="column-chart" class="h-64 bg-gray-100 rounded-md"></div>
            </div>
        </section>
    </div>

    <script>
        const options = {
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
            },
            series: [{
                    name: "Frontend Development",
                    data: [{
                            x: "January",
                            y: 120
                        },
                        {
                            x: "February",
                            y: 150
                        },
                        {
                            x: "March",
                            y: 170
                        },
                        {
                            x: "April",
                            y: 180
                        },
                        {
                            x: "May",
                            y: 210
                        },
                        {
                            x: "June",
                            y: 220
                        },
                        {
                            x: "July",
                            y: 240
                        },
                    ],
                },
                {
                    name: "Data Science",
                    data: [{
                            x: "January",
                            y: 100
                        },
                        {
                            x: "February",
                            y: 130
                        },
                        {
                            x: "March",
                            y: 160
                        },
                        {
                            x: "April",
                            y: 190
                        },
                        {
                            x: "May",
                            y: 200
                        },
                        {
                            x: "June",
                            y: 210
                        },
                        {
                            x: "July",
                            y: 230
                        },
                    ],
                },
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadius: 8,
                },
            },
            xaxis: {
                labels: {
                    style: {
                        fontFamily: "Inter, sans-serif",
                    }
                },
            },
            yaxis: {
                show: true,
            },
            fill: {
                opacity: 1,
            },
        };

        if (document.getElementById("column-chart")) {
            const chart = new ApexCharts(document.getElementById("column-chart"), options);
            chart.render();
        }
    </script>
@endcomponent
