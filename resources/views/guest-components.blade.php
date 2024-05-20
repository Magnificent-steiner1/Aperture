<style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    .hero-section {
        height: 100vh;
        /* background-image: url('/images/background/bg-home3.jpg'); */
        background-color: yellow;
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .hero-content {
        z-index: 2;
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .btn-hero {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-hero:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .services,
    .cta {
        padding: 60px 0;
        text-align: center;
    }

    .service-item.wedding {
        background-color: #FFD700;
    }

    .service-item.portrait {
        background-color: #FFA07A;
    }

    .service-item.event {
        background-color: #ADD8E6;
    }

    .service-item {
        padding: 20px;
        border-radius: 0px;
        margin-bottom: 20px;
    }

    .service-item h3,
    .service-item p {
        color: #fff;
    }

    .portfolio {
        padding: 60px 0;
        background-color: #f8f9fa;
    }

    .portfolio img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .portfolio img:hover {
        transform: scale(1.05);
    }

    .testimonials {
        padding: 60px 0;
        background-color: #343a40;
        color: white;
    }

    .testimonial-item {
        margin-bottom: 30px;
    }



    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .cta-container {
            display: flex;
            justify-content: space-around;
            background-color: #f8f9fa; 
            padding: 60px 0;
            position: relative;
        }

        .cta {
            flex: 0 1 45%;
            text-align: center;
        }

        .cta h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
            opacity: 0; 
            animation: fadeInLeft 1s forwards; 
        }

        .cta p {
            margin-bottom: 40px;
            color: #666;
            opacity: 0; 
            animation: fadeInLeft 1s forwards 0.5s; 
        }

        .cta .btn {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUp 1s forwards 1s; 
        }

        .cta .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
    .floating-images {
        position: absolute;
        animation: float 6s ease-in-out infinite;
    }

    .floating-images img {
        width: 300px;
        height: 400px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .f1 {
        top: 15%;
        left: 25%;
    }

    .f2{
        top: 25%;
        left: 40%;
    }

    .f3 {
        top: 35%;
        left: 55%;
    }
</style>


<div class="hero-section">
    <div class="hero-content">
        <h1>Welcome to Aperture</h1>
        <p>Find the perfect photographer for your special moments.</p>
        <a href="/login">
            <button class="btn btn-hero">Get Started</button>
        </a>
    </div>
    <div class="floating-images f1">
        <img src="{{URL::asset('/images/body/pexels-luis-quintero-1738636.jpg')}}" alt="Floating Image 1">
    </div>
    <div class="floating-images f2">
        <img src="{{URL::asset('/images/body/pexels-atc-comm-photo-302355.jpg')}}" alt="Floating Image 2">
    </div>
    <div class="floating-images f3">
        <img src="{{URL::asset('/images/body/pexels-pnw-production-7062068.jpg')}}" alt="Floating Image 3">
    </div>

</div>


<section id="services" class="services">
    <div class="container">
        <h2>Aperture Services</h2>
        <div class="row">
            <div class="col-md-4 service-item wedding">
                <i class="bi bi-camera2" style="font-size: 2rem;"></i>
                <h3>Wedding Photography</h3>
                <p>Capture your special day with our professional wedding photography services.</p>
            </div>
            <div class="col-md-4 service-item portrait">
                <i class="bi bi-person-lines-fill" style="font-size: 2rem;"></i>
                <h3>Portrait Photography</h3>
                <p>Get stunning portraits with our expert portrait photographers.</p>
            </div>
            <div class="col-md-4 service-item event">
                <i class="bi bi-camera-reels-fill" style="font-size: 2rem;"></i>
                <h3>Event Photography</h3>
                <p>Document your events with high-quality event photography services.</p>
            </div>
        </div>
    </div>
</section>


<div class="cta-container">
    <section class="cta">
        <h2>Are you a photographer? Looking for a job or want to showcase your work?</h2>
        <p>Aperture is the place you're looking for.</p>
        <a href="/register">
       <button class="btn btn-primary">Join as Photographer</button>
       </a>
    </section>



    <section class="cta">
        <h2>Want to capture your moment? Can't find professionals?</h2>
        <p>We have the best!</p>
        <a href="/register">
        <button class="btn btn-primary">Find a Photographer</button>
        </a>
    </section>
</div>



<section id="testimonials" class="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-md-4 testimonial-item">
                <p>"Aperture toh kam korena bhai!"</p>
                <small>- Asif Mahmud</small>
            </div>
            <div class="col-md-4 testimonial-item">
                <p>"Feeling BLU"</p>
                <small>- Rafsan</small>
            </div>
            <div class="col-md-4 testimonial-item">
                <p>"Trash developer"</p>
                <small>- Heisenberg</small>
            </div>
        </div>
    </div>
</section>

