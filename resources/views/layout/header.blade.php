<style>
    .drname {
        color: #000;
        font-weight: 500;
    }

    .positions {
        font-size: 14px;
        color: #444;
    }

    /* Mobile view adjustments */
    @media (max-width: 768px) {
        .drname {
            font-weight: 100;
            font-size: smaller;
        }

        .positions {
            font-size: 12px;
        }

        .navbar-brand img {
            width: 160px;
            height: auto;
        }
    }

    /* ✨ Modern mobile toggle button */
    .menu-toggle {
        background-color: #0e610d;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .menu-toggle:hover {
        background-color: #0c520b;
        transform: scale(1.05);
    }

    .menu-toggle i {
        font-size: 20px;
    }

    /* Optional: subtle shadow for floating effect */
    .menu-toggle {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark mx-auto"
    style="max-height:100px; overflow: hidden;max-width:95%;">
    <!-- Logo on the left -->
    <a class="navbar-brand d-flex align-items-center py-1" href="#">
        <img src="{{ asset('Image/logo.png') }}" alt="Logo" width="300px" height="80px" class="img-fluid">
    </a>

    <!-- Right-aligned profile section -->
    <div class="ms-auto d-flex align-items-center">
        <div class="text-end me-3">
            <div class="drname">Dr.SIVAMURUGAN</div>
            <div class="positions">Senior Consultant</div>
        </div>
        <i class="fas fa-user-circle" style="font-size:36px;color:#126328;"></i>
        <div class="d-flex justify-content-between align-items-center d-lg-none p-2 w-100">
            <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i> 
            </button>
        </div>
    </div>

    <!-- Mobile Menu Toggle Button -->
</nav>
