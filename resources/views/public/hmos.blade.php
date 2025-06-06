<style scoped>

    .carousel-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding: 16px 0;
    }

    .gradient {
        position: absolute;
        top: 0;
        height: 100%;
        width: 80px;
        z-index: 10;
    }

    .left-gradient {
        left: 0;
        background: linear-gradient(to right, var(--bg-color), transparent);
    }

    .right-gradient {
        right: 0;
        background: linear-gradient(to left, var(--bg-color), transparent);
    }

    .carousel {
        display: flex;
        animation: scroll 10s linear infinite;
        will-change: transform;
    }

    .logos-slide {
        display: flex;
        align-items: center;
        justify-content: space-around;
        flex-shrink: 0;
    }

    .logo-item {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 64px;
        width: 128px;
        margin: 0 32px;
    }

    .logo {
        max-height: 48px;
        width: 100%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.2s ease;
        aspect-ratio: 1/1;
        opacity: 0.8;
    }

    .logo:hover {
        filter: grayscale(0%);
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    @media (max-width: 768px) {
        .logo-item {
            margin: 0 16px;
            width: 100px;
        }

        .gradient {
            width: 40px;
        }
    }

</style>

<div class="carousel-container">
    <div class="gradient left-gradient"></div>
    <div class="gradient right-gradient"></div>

    {{-- <div class="carousel"> --}}
    <div class="carousel">

        <div class="logos-slide">
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo1.png')}}" alt="Company 1" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo2.png')}}" alt="Company 2" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo3.png')}}" alt="Company 3" class="logo">
            </div>
            <div class="logo-item bg-gray-800 p-3">
                <img src="{{asset('images/frontend_asset/hmo4.png')}}" alt="Company 4" class="logo  ">
            </div>
        </div>

      <div class="logos-slide">
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo1.png')}}" alt="Company 1" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo2.png')}}" alt="Company 2" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo3.png')}}" alt="Company 3" class="logo">
            </div>
            <div class="logo-item bg-gray-800 p-3">
                <img src="{{asset('images/frontend_asset/hmo4.png')}}" alt="Company 4" class="logo  ">
            </div>
        </div>
        <div class="logos-slide">
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo1.png')}}" alt="Company 1" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo2.png')}}" alt="Company 2" class="logo">
            </div>
            <div class="logo-item">
                <img src="{{asset('images/frontend_asset/hmo3.png')}}" alt="Company 3" class="logo">
            </div>
            <div class="logo-item bg-gray-800 p-3">
                <img src="{{asset('images/frontend_asset/hmo4.png')}}" alt="Company 4" class="logo  ">
            </div>
        </div>
    </div>
  </div>
