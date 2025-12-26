<x-modal id="main-search" width="w-[90%] md:w-[60%]">
    <h2 class="text-xl font-bold mb-3 pr-4">جستجوی غذا</h2>

    <input type="text" placeholder="جستجو کنید..." id="main-search-input"
        class="text-2xl rounded-2xl outline-blue-100 w-full px-4 py-3 bg-gray-50">

    <div id="search-404-div" class="hidden bg-gray-50 mt-8 text-center py-8 rounded-2xl shadow">
        <span class="text-3xl mb-4 block">موردی یافت نشد</span>
        <span>دوباره جستجو کنید</span>
    </div>

    <div id="search-default-div" class="bg-gray-50 mt-8 text-center py-8 rounded-2xl shadow">
        <span class="text-3xl mb-4 block">جستجو کنید</span>
        <span>اسم غذای مورد نظر را جستجو کنید</span>
    </div>

    <div id="search-results"></div>

</x-modal>
