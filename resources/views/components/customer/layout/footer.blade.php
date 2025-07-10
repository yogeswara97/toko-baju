<!-- Footer Component -->
<footer class="bg-gray-900 text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <h3 class="text-xl font-medium mb-3 uppercase">{{ config('app.name') }}</h3>
            <p class="text-gray-400">Your destination for premium fashion and style.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Quick Links</h4>
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white">Products</a></li>
                <li><a href="#" class="hover:text-white">Categories</a></li>
                <li><a href="#" class="hover:text-white">About</a></li>
                <li><a href="#" class="hover:text-white">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Support</h4>
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white">Returns</a></li>
                <li><a href="#" class="hover:text-white">Shipping</a></li>
                <li><a href="#" class="hover:text-white">FAQs</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Follow Us</h4>
            <div class="flex gap-4 text-gray-400">
                <a href="#"><i class="fab fa-facebook hover:text-white"></i></a>
                <a href="#"><i class="fab fa-instagram hover:text-white"></i></a>
                <a href="#"><i class="fab fa-twitter hover:text-white"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center text-gray-500 mt-8">&copy; 2024 {{ config('app.name') }}. All rights reserved.</div>
</footer>
