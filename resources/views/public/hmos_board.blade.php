<style scoped>
    .carousel-container {
      position: relative;
      overflow: hidden;
      width: 100%;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
    }

    .logo-item {
      position: absolute;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
      width: 150px;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo {
      width: 100%;
      height: auto;
      object-fit: contain;
      filter: grayscale(100%);
      opacity: 0.8;
      transition: filter 0.3s ease;
    }

    .logo:hover {
      filter: grayscale(0%);
    }

    /* 🪄 Fading Animation */
    @keyframes fade {
      0% { opacity: 0; }
      5% { opacity: 1; }
      25% { opacity: 1; }
      30% { opacity: 0; }
      100% { opacity: 0; }
    }

    /* 🧠 Each logo gets its own timing */
    .logo-item:nth-child(1) {
      animation: fade 16s infinite;
      animation-delay: 0s;
    }
    .logo-item:nth-child(2) {
      animation: fade 16s infinite;
      animation-delay: 4s;
    }
    .logo-item:nth-child(3) {
      animation: fade 16s infinite;
      animation-delay: 8s;
    }
    .logo-item:nth-child(4) {
      animation: fade 16s infinite;
      animation-delay: 12s;
    }
    </style>

    <div class="carousel-container">
        <div class="logo-item">
            <img src="{{ asset('images/frontend_asset/hmo1.png') }}" alt="Company 1" class="logo" />
        </div>
        <div class="logo-item">
            <img src="{{ asset('images/frontend_asset/hmo2.png') }}" alt="Company 2" class="logo" />
        </div>
        <div class="logo-item">
            <img src="{{ asset('images/frontend_asset/hmo3.png') }}" alt="Company 3" class="logo" />
        </div>
        <div class="logo-item bg-black">
            <img src="{{ asset('images/frontend_asset/hmo4.png') }}" alt="Company 4" class="logo" />
        </div>
    </div>
