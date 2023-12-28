<div class="w-[250px] fixed top-0 left-0 h-[100vh] bg-[#343a40] text-[1.6rem] shadow-lg" id="main-sidebar">
    <div class="header p-2 border-bottom border-[#4b545c] h-[56px] flex justify-center">
        <img src="{{ asset('images/logo.png') }}" alt="img-logo" class="h-100"/>
    </div>
    <div class="">
        <div class="side-bar-form p-[1rem] relative p-[.5rem]">
            <input
                class="w-100 leading-[24px] py-[6px] pl-[12px] pr-[30px] border-2 bg-[#343a40] 
                outline-0 rounded focus:bg-white focus:border-[#80bdff] text-[#929292]"
                type="text" name="search-side-bar" placeholder="Search">
            <img class="transform scale-x-[-1] absolute top-[50%] translate-y-[-50%] right-[13px] w-[2.4rem]"
                src="{{ asset('images/icons/search-input.svg') }}" alt="icon-search">
        </div>
        <nav class="mt-3">
            <ul>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="{{ route('admin.index') }}" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-desktop mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Dashboard</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="{{ route('product.index') }}" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-book mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Products</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-shopping-cart mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Sales</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-user mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Customers</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-tags mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Promotions</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-cubes mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Content management</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-cogs mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Cofiguration</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-cube mx-3 text-[2rem]"></i>
                        <p class="text-inherit">System</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-chart-line mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Report</p>
                    </a>
                </li>
                <li class="p-[10px] hover:bg-[#ffffff1a] hover:text-white text-[#c2c7d0]">
                    <a href="" class="flex items-center hover:text-white">
                        <i class="text-inherit nav-icon fas fa-circle-question mx-3 text-[2rem]"></i>
                        <p class="text-inherit">Help</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
