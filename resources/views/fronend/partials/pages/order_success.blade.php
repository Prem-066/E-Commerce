@extends('fronend.partials.app')
@section('title', 'Order Success')

@section('contentt')
<style>
    .success-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        margin-top: -80px;
        position: relative;
        z-index: 2;
        opacity: 0;
        transform: translateY(30px);
        animation: cardEntrance 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        animation-delay: 0.2s;
    }

    @keyframes cardEntrance {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .check-container {
        width: 110px;
        height: 110px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        margin: 0 auto 25px;
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.3);
        opacity: 0;
        transform: scale(0.5) rotate(-15deg);
        animation: checkEntrance 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        animation-delay: 0.5s;
    }

    @keyframes checkEntrance {
        to {
            opacity: 1;
            transform: scale(1) rotate(0);
        }
    }

    .confetti-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
    }

    .order-info-box {
        background: #fdfdfd;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #f1f1f1;
        transition: all 0.3s ease;
    }

    .order-info-box:hover {
        border-color: #28a745;
        background: #f8fff9;
    }

    .success-heading {
        background: linear-gradient(to right, #222, #555);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        font-size: 32px;
    }

    .primary-btn {
        background: #ffba00;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(255, 186, 0, 0.3);
    }

    .primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 186, 0, 0.4);
        background: #e6a800;
        color: white;
    }
</style>

<section class="banner-area organic-breadcrumb" style="height: 300px;">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-center">
            <div class="col-first text-center">
                <h1 style="font-size: 48px; letter-spacing: 2px;">Thank You!</h1>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
            <div class="success-card">
                <div class="check-container">
                    <i class="fa fa-check"></i>
                </div>
                <h2 class="success-heading mb-2">Order Successfully Placed!</h2>
                <p class="text-muted px-lg-5">Yippee! Your order has been placed. We are preparing your goodies with love and will ship them out soon.</p>

                <div class="order-info-box my-4 shadow-sm">
                    <div class="row text-start">
                        <div class="col-6 mb-3">
                            <span class="text-muted small text-uppercase fw-bold">Order ID</span><br>
                            <span class="text-dark fw-bold" style="font-size: 18px;">#{{ session('order_number', 'TE-'.rand(1000,9999)) }}</span>
                        </div>
                        <div class="col-6 mb-3 text-end">
                            <span class="text-muted small text-uppercase fw-bold">Order Date</span><br>
                            <strong class="text-dark">{{ date('d M, Y') }}</strong>
                        </div>
                        <div class="col-12 border-top pt-3">
                            <i class="fa fa-truck text-success mr-2"></i>
                            <span class="text-muted small">Expect Delivery:</span>
                            <strong class="text-success ml-1">Within 3-5 Working Days</strong>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('trend-era-shop') }}" class="primary-btn w-100 py-3 rounded text-decoration-none">Continue Shopping</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('order.history') }}" class="btn btn-light w-100 py-3 rounded fw-bold border" style="color: #666;">Track Order Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    window.addEventListener('load', function() {
        const count = 200;
        const defaults = {
            origin: {
                y: 0.7
            },
            zIndex: 9999
        };

        function fire(particleRatio, opts) {
            confetti({
                ...defaults,
                ...opts,
                particleCount: Math.floor(count * particleRatio)
            });
        }

        // Phase 1: Big Bang Burst
        setTimeout(() => {
            fire(0.25, {
                spread: 26,
                startVelocity: 55
            });
            fire(0.2, {
                spread: 60
            });
            fire(0.35, {
                spread: 100,
                decay: 0.91,
                scalar: 0.8
            });
            fire(0.1, {
                spread: 120,
                startVelocity: 25,
                decay: 0.92,
                scalar: 1.2
            });
            fire(0.1, {
                spread: 120,
                startVelocity: 45
            });
        }, 600);

        // Phase 2: Fireworks Show
        const duration = 4 * 1000;
        const animationEnd = Date.now() + duration;
        const colors = ['#ffba00', '#28a745', '#007bff', '#ff4d4d', '#f335fa'];

        (function frame() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) return;

            const particleCount = 2;

            // Side cannons
            confetti({
                particleCount,
                angle: 60,
                spread: 55,
                origin: {
                    x: 0
                },
                colors: colors
            });
            confetti({
                particleCount,
                angle: 120,
                spread: 55,
                origin: {
                    x: 1
                },
                colors: colors
            });

            // Random fireworks
            if (Math.random() > 0.8) {
                confetti({
                    particleCount: 15,
                    startVelocity: 30,
                    spread: 360,
                    origin: {
                        x: Math.random(),
                        y: Math.random() * 0.5 + 0.2
                    },
                    colors: colors,
                    shapes: ['circle', 'star'],
                    gravity: 1.2,
                    scalar: 0.7
                });
            }

            requestAnimationFrame(frame);
        }());

        // Phase 3: Final Star Shower
        setTimeout(() => {
            const end = Date.now() + 2000;
            (function finalFrame() {
                confetti({
                    particleCount: 2,
                    angle: 90,
                    spread: 360,
                    origin: {
                        x: Math.random(),
                        y: 0
                    },
                    colors: ['#ffba00'],
                    shapes: ['star']
                });
                if (Date.now() < end) requestAnimationFrame(finalFrame);
            }());
        }, 5000);
    });
</script>
@endsection