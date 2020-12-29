<div class="card">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a 
            href="{{ route('profile.index') }}" 
            class="nav-link {{ Route::current()->getName() == 'profile.index' ? 'active' : '' }}"
        >
            <i class="fa fa-user"></i> Manage Profile
        </a>
        <a 
            href="{{ route('orders.index') }}" 
            class="nav-link {{ Route::current()->getName() == 'orders.index' ? 'active' : '' }}"
        >
            <i class="fa fa-shopping-cart"></i> My Orders
        </a>
        <a 
            href="{{ route('change-password') }}" 
            class="nav-link {{ Route::current()->getName() == 'change-password' ? 'active' : '' }}"
        >
            <i class="fa fa-key"></i> Change Password
        </a>
    </div>
</div>