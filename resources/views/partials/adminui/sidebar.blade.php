<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon icon-single-04"></i><span
                        class="nav-text">Dashboard</span></a>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-single-copy-06"></i><span class="nav-text">Dynamic Forms</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.dynamicForms.index') }}">Dynamic Form List</a></li>
                    <li><a href="{{ route('admin.dynamicForms.create') }}">Create Dynamic Form</a></li>
                </ul>
            </li>



        </ul>
    </div>
</div>
