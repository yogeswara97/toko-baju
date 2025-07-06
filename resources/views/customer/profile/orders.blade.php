<x-customer.layout.layout>
    <section class="container-custom">
        <!-- Order Details Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                         <h1 class="text-2xl font-bold text-gray-900">Order #{{ $slug }}
                        <p class="text-gray-600">Placed on March 15, 2024</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Delivered</span>
                        <p class="text-2xl font-bold text-gray-900 mt-2">$129.99</p>
                    </div>
                </div>

                <!-- Order Progress -->
                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Order Placed</span>
                    </div>
                    <div class="flex-1 h-1 bg-green-500 mx-4"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Processing</span>
                    </div>
                    <div class="flex-1 h-1 bg-green-500 mx-4"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Shipped</span>
                    </div>
                    <div class="flex-1 h-1 bg-green-500 mx-4"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Delivered</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Order Items</h2>

                        <div class="space-y-4">
                            <div class="flex items-center border-b border-gray-200 pb-4">
                                <img src="/placeholder.svg?height=80&width=80" alt="Premium Cotton T-Shirt" class="w-16 h-16 object-cover rounded">
                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold text-gray-900">Premium Cotton T-Shirt</h3>
                                    <p class="text-gray-600 text-sm">Color: Navy Blue, Size: M</p>
                                    <p class="text-gray-600 text-sm">Quantity: 2</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">$59.98</p>
                                    <p class="text-sm text-gray-600">$29.99 each</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <img src="/placeholder.svg?height=80&width=80" alt="Denim Jacket" class="w-16 h-16 object-cover rounded">
                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold text-gray-900">Denim Jacket</h3>
                                    <p class="text-gray-600 text-sm">Color: Blue, Size: L</p>
                                    <p class="text-gray-600 text-sm">Quantity: 1</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">$79.99</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                    <i class="fas fa-redo mr-2"></i>Reorder
                                </button>
                                <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <i class="fas fa-star mr-2"></i>Write Review
                                </button>
                                <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <i class="fas fa-download mr-2"></i>Download Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Details -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Order Summary</h3>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>$139.97</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>$9.99</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span>$14.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount</span>
                                <span class="text-green-600">-$33.97</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>$129.99</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium text-gray-900">John Doe</p>
                            <p>123 Main Street</p>
                            <p>Apt 4B</p>
                            <p>Jakarta, DKI Jakarta 12345</p>
                            <p>Indonesia</p>
                            <p class="mt-2">+62 812 3456 7890</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Method</h3>
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-gray-400 mr-3"></i>
                            <div>
                                <p class="font-medium">Credit Card</p>
                                <p class="text-sm text-gray-600">**** **** **** 1234</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tracking Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Tracking Information</h3>
                        <div class="text-sm">
                            <p class="font-medium">Tracking Number</p>
                            <p class="text-blue-600 mb-3">TRK123456789</p>

                            <p class="font-medium">Carrier</p>
                            <p class="text-gray-600 mb-3">JNE Express</p>

                            <p class="font-medium">Estimated Delivery</p>
                            <p class="text-gray-600">March 18, 2024</p>
                        </div>

                        <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Track Package
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-customer.layout.layout>
