<?php $base_url = route('admin.admin-dashboard'); ?>
<aside id="sidebar">
    <div class="d-flex">

        <div class="sidebar-logo">
            <a href="{{$base_url}}">Cleanova</a>
        </div>
        <button id="toggle-btn" type="button">
            <i class="lni lni-menu-cheesburger"></i>
        </button>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{$base_url}}" class="sidebar-link">
                <i class="lni lni-dashboard-square-1"></i>
                <span>پیشخوان</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#category"
               aria-expanded="false" aria-controls="category">
                <i class="lni lni-agenda"></i>
                <span>دسته بندی</span>
            </a>
            <ul id="category" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/category/create" class="sidebar-link">افزودن دسته</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{$base_url}}/category" class="sidebar-link">مدیریت دسته ها</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#brand"
               aria-expanded="false" aria-controls="brand">
                <i class="lni lni-box-archive-1"></i>
                <span>برندها</span>
            </a>
            <ul id="brand" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/brand/create" class="sidebar-link">افزودن برند</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{$base_url}}/brand" class="sidebar-link">مدیریت برندها</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#product"
               aria-expanded="false" aria-controls="product">
                <i class="lni lni-box-archive-1"></i>
                <span>محصولات</span>
            </a>
            <ul id="product" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/product/create" class="sidebar-link">افزودن محصول</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{$base_url}}/product" class="sidebar-link">مدیریت محصولات</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#users"
               aria-expanded="false" aria-controls="users">
                <i class="lni lni-box-archive-1"></i>
                <span>کاربران</span>
            </a>
            <ul id="users" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/user" class="sidebar-link">مدیریت کاربران</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#order" aria-expanded="false" aria-controls="order">
                <i class="lni lni-credit-card-multiple"></i>
                <span>سفارشات</span>
            </a>
            <ul id="order" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/order" class="sidebar-link">مدیریت سفارشات</a>
                </li>
            </ul>

        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
               data-bs-toggle="collapse" data-bs-target="#setting" aria-expanded="false" aria-controls="setting">
                <i class="lni lni-database-2"></i>
                <span>تنظیمات</span>
            </a>
            <ul id="setting" class="sidebar-dropdown list-unstyled collapse"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{$base_url}}/shipping" class="sidebar-link">حمل و نقل</a>
                </li>
            </ul>

        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="/logout" class="sidebar-link">
            <i class="lni lni-exit"></i>
            <span>خروج</span>
        </a>
    </div>
</aside>
