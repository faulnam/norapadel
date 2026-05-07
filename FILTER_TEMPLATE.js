// Product Filter Script - Copy this to Racket, Shoes, and Apparel pages

// Add this HTML before the product grid:
/*
<!-- Search & Filter -->
<div class="mb-6 space-y-4">
    <div class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
        </div>
        <div class="flex gap-2 flex-wrap">
            <select id="filterDiscount" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                <option value="">Semua Diskon</option>
                <option value="yes">Ada Diskon</option>
                <option value="no">Tanpa Diskon</option>
            </select>
            <select id="filterBundle" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                <option value="">Semua Produk</option>
                <option value="yes">Bundling Hemat</option>
                <option value="no">Produk Satuan</option>
            </select>
            <select id="filterPopular" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                <option value="">Semua</option>
                <option value="yes">Sering Dibeli</option>
            </select>
            <button id="filterPrice" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm hover:bg-zinc-50 transition">
                <i class="fas fa-sliders-h mr-2"></i>Harga
            </button>
        </div>
    </div>

    <!-- Price Range Filter -->
    <div id="priceRangeFilter" class="hidden bg-zinc-50 border border-zinc-200 rounded-xl p-4">
        <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
                <label class="text-xs text-zinc-600 mb-1 block">Harga Min</label>
                <input type="number" id="minPrice" placeholder="0" class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="text-xs text-zinc-600 mb-1 block">Harga Max</label>
                <input type="number" id="maxPrice" placeholder="999999999" class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>
        </div>
        <div class="flex gap-2">
            <button id="applyPriceFilter" class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                Terapkan
            </button>
            <button id="resetPriceFilter" class="px-4 py-2 border border-zinc-300 rounded-lg text-sm hover:bg-white transition">
                Reset
            </button>
        </div>
    </div>
</div>
*/

// Update product grid div to have id="productGrid"
// Add data attributes to each product link:
/*
data-name="{{ strtolower($product->name) }}"
data-price="{{ $product->hasActiveDiscount() ? $product->discounted_price : $product->price }}"
data-discount="{{ $product->hasActiveDiscount() ? 'yes' : 'no' }}"
data-bundle="{{ $product->package_type === 'bundle' ? 'yes' : 'no' }}"
data-sold="{{ $soldCount }}"
*/

// Add class="product-item" to each product link

// Add this after the product grid:
/*
<div id="noResults" class="hidden text-center py-12">
    <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
    <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
</div>
*/

// Add this JavaScript in @push('scripts'):
/*
// Filter functionality
const searchInput = document.getElementById('searchProduct');
const filterDiscount = document.getElementById('filterDiscount');
const filterBundle = document.getElementById('filterBundle');
const filterPopular = document.getElementById('filterPopular');
const filterPriceBtn = document.getElementById('filterPrice');
const priceRangeFilter = document.getElementById('priceRangeFilter');
const minPriceInput = document.getElementById('minPrice');
const maxPriceInput = document.getElementById('maxPrice');
const applyPriceBtn = document.getElementById('applyPriceFilter');
const resetPriceBtn = document.getElementById('resetPriceFilter');
const productGrid = document.getElementById('productGrid');
const noResults = document.getElementById('noResults');
const products = document.querySelectorAll('.product-item');

let minPrice = 0;
let maxPrice = Infinity;

filterPriceBtn?.addEventListener('click', () => {
    priceRangeFilter.classList.toggle('hidden');
});

function filterProducts() {
    const searchTerm = searchInput.value.toLowerCase();
    const discountFilter = filterDiscount.value;
    const bundleFilter = filterBundle.value;
    const popularFilter = filterPopular.value;
    let visibleCount = 0;

    products.forEach(product => {
        const name = product.dataset.name;
        const price = parseFloat(product.dataset.price);
        const hasDiscount = product.dataset.discount;
        const isBundle = product.dataset.bundle;
        const soldCount = parseInt(product.dataset.sold);

        let show = true;

        if (searchTerm && !name.includes(searchTerm)) show = false;
        if (discountFilter === 'yes' && hasDiscount !== 'yes') show = false;
        if (discountFilter === 'no' && hasDiscount === 'yes') show = false;
        if (bundleFilter === 'yes' && isBundle !== 'yes') show = false;
        if (bundleFilter === 'no' && isBundle === 'yes') show = false;
        if (popularFilter === 'yes' && soldCount < 5) show = false;
        if (price < minPrice || price > maxPrice) show = false;

        if (show) {
            product.style.display = '';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });

    if (visibleCount === 0) {
        productGrid.classList.add('hidden');
        noResults.classList.remove('hidden');
    } else {
        productGrid.classList.remove('hidden');
        noResults.classList.add('hidden');
    }
}

searchInput?.addEventListener('input', filterProducts);
filterDiscount?.addEventListener('change', filterProducts);
filterBundle?.addEventListener('change', filterProducts);
filterPopular?.addEventListener('change', filterProducts);

applyPriceBtn?.addEventListener('click', () => {
    minPrice = parseFloat(minPriceInput.value) || 0;
    maxPrice = parseFloat(maxPriceInput.value) || Infinity;
    filterProducts();
});

resetPriceBtn?.addEventListener('click', () => {
    minPriceInput.value = '';
    maxPriceInput.value = '';
    minPrice = 0;
    maxPrice = Infinity;
    filterProducts();
});
*/
