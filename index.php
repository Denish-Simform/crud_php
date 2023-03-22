<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JNV Jamnagar Alumni Association</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/bootstrap/style.css">
</head>
<body class="bg-dark" data-spy="scroll" data-target="#navbar" data-offset-top="200">
    <nav class="navbar sticky-top navbar-expand-lg bg-dark" id="navbar">
        <div class="container-fluid">
            <img src="assets/images/logo-small.png" class="me-3" alt="">
            <a class="navbar-brand text-light me-0" href="#">JNV Jamnagar Alumni Association</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="scrollHide('home')">Home</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="scrollHide('batches')">Batches</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="scrollHide('events')">Events</button>
                    </li>
                    <li class="nav-item"> 
                        <button type="button" class="btn btn-dark text-white" onclick="scrollHide('testimonials')">Testimonials</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="scrollHide('photos')">Photos</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="register()">Register</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="login()">
                            <?php 
                                if(isset($_COOKIE["id"]) || isset($_SESSION["id"])) {
                                    echo "Profile";
                                } else {
                                    echo "Log In";
                                    }
                            ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex justify-content-center section_toggle" id="carousel">
        <div id="carouselExampleIndicators" class="carousel slide w-75 h-50" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 h-50" src="assets/images/slider-1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slider-2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slider-3.png" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slider-4.png" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slider-5.png" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <button id="back-to-top-btn" class="btn btn-primary btn-lg back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <section class="mt-5 batches section_toggle" id="batches">
        <div class="container p-5">
            <div class="row text-center text-light">
                <h1>COME IN TO LEARN, GO OUT TO SERVE</h1>
                <div class="col-sm-2 mt-5">
                    <img src="assets/images/jnv_logo.jpg" class="img-fluid rounded" alt="jnv_logo">
                </div>
                <div class="col-sm-3 mt-5"></div>
                <div class="col-sm-7 text-light mt-5 text-start">
                    Jawahar Navodaya Vidyalaya (JNV) Jamnagar is a co-educational, residential school located in the
                    city of
                    Jamnagar, Gujarat, India. It is part of the Navodaya Vidyalaya Samiti, a government-run organization
                    that operates a chain of schools across India. The aim of JNV Jamnagar, as well as other JNVs, is to
                    provide quality education to talented children from rural areas of India.

                    JNV Jamnagar follows the CBSE (Central Board of Secondary Education) curriculum and offers classes
                    from
                    VI to XII. The medium of instruction is primarily Hindi and English. Admissions to JNV Jamnagar are
                    based on a nationwide entrance exam, known as the Jawahar Navodaya Vidyalaya Selection Test (JNVST),
                    which is held annually for students in Class V.

                    JNV Jamnagar provides a well-rounded education that emphasizes academics, sports, and co-curricular
                    activities. The school has a dedicated team of experienced teachers and state-of-the-art facilities
                    to
                    support student learning and development. The school also provides free boarding and lodging to all
                    students.
                </div>
            </div>
        </div>
        <div class="container bg-dark p-5">
            <div class="row text-center">
                <h1 class="text-light">Our Batches</h1>
                <div class="mt-5 row">
                    <div class="col-2 d-flex my-auto">
                        <select class="form-select h-25" aria-label="default select example">
                            <option selected>2000-2005</option>
                            <option value="1">2006-2010</option>
                            <option value="2">2011-2015</option>
                            <option value="3">2016-2020</option>
                        </select>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-1.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2000-2006</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-2.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2001-2007</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-3.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2002-2008</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-1.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2003-2009</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-2.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2004-2010</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card">
                                    <img src="assets/images/person-1.png" class="card-img-top" alt="Card Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2005-2011</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-5 section_toggle events" id="events">
        <div class="container p-5">
            <h1 class="text-center text-light">Upcoming Events : Stay Tuned</h1>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/images/event-1.jpg" class="card-img-top" alt="Event 1">
                        <div class="card-body">
                            <h5 class="card-title">Event 1</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod odio, gravida pellentesque urna varius vitae.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/images/event-2.jpg" class="card-img-top" alt="Event 2">
                        <div class="card-body">
                            <h5 class="card-title">Event 2</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod odio, gravida pellentesque urna varius vitae.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/images/event-4.jpg" class="card-img-top" alt="Event 3">
                        <div class="card-body">
                            <h5 class="card-title">Event 3</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod odio, gravida pellentesque urna varius vitae.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mt-5 section_toggle testimonials" id="testimonials">
        <div class="p-5">
            <div class="text-center">
                <h1 class="heading text-light">
                    Testimonials
                </h1>
            </div>
            <div id="testimonial-carousel" class="carousel slide mt-5" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#testimonial-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#testimonial-carousel" data-slide-to="1"></li>
                    <li data-target="#testimonial-carousel" data-slide-to="2"></li>
                </ol>
                <!-- Slides -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <p class="card-text">"I am proud to be a part of the JNV Jamnagar Alumni
                                        Association.
                                        The
                                        community and network that this association provides is invaluable, and I have
                                        made
                                        lifelong friends through my involvement. The events and initiatives organized by
                                        the
                                        association keep us connected to our alma mater and allow us to give back to
                                        current
                                        students. I am grateful for the opportunities and memories that this association
                                        has
                                        provided me and I highly recommend it to all JNV Jamnagar alumni."
                                    </p>
                                    <img src="assets/images/person-1.png" alt="person-1" class="h-25 w-25">
                                </div>
                                <h4 class="card-title">John Doe</h4>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <p class="card-text">"Being a part of the JNV Jamnagar Alumni Association has been a
                                        truly
                                        enriching experience for me. The community of alumni is supportive and
                                        welcoming,
                                        and
                                        the events and initiatives organized by the association have allowed me to stay
                                        connected with my alma mater and give back to the school in meaningful ways. I
                                        am
                                        proud
                                        to be a part of this vibrant and dynamic network and look forward to continuing
                                        my
                                        involvement in the future."
                                    </p>
                                    <img src="assets/images/person-2.png" alt="" class="h-25 w-25">
                                </div>
                                <h4 class="card-title">Jane Doe</h4>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card testimonial-card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <p class="card-text">"I am proud to be a part of the JNV Jamnagar Alumni
                                        Association.
                                        This
                                        organization has not only provided me with an opportunity to reconnect with my
                                        old
                                        classmates, but also with a platform to give back to the community and make a
                                        difference
                                        in the lives of current students. The events and initiatives organized by the
                                        Association have not only helped me to stay connected with my alma mater but
                                        also
                                        given
                                        me a sense of belonging to a larger community. I highly recommend joining this
                                        Association to all JNV alumni, as it's a wonderful way to stay connected and
                                        make a
                                        positive impact."
                                    </p>
                                    <img src="assets/images/person-3.png" alt="" class="h-25 w-25">
                                </div>
                                <h4 class="card-title">Jim Smith</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <a class="carousel-control-prev" href="#testimonial-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#testimonial-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </section>
    <section class="mt-5 section_toggle photos" id="photos">
        <div class="container p-5">
            <h1 class="text-center text-light">Photo Gallery</h1>
            <div class="row mt-5">
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo1.jpg" data-toggle="lightbox" data-title="Photo 1">
                        <img src="assets/images/slider-1.png" class="img-fluid" alt="Photo 1">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo2.jpg" data-toggle="lightbox" data-title="Photo 2">
                        <img src="assets/images/slider-2.png" class="img-fluid" alt="Photo 2">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo3.jpg" data-toggle="lightbox" data-title="Photo 3">
                        <img src="assets/images/slider-3.png" class="img-fluid" alt="Photo 3">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo4.jpg" data-toggle="lightbox" data-title="Photo 4">
                        <img src="assets/images/slider-4.png" class="img-fluid" alt="Photo 4">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo5.jpg" data-toggle="lightbox" data-title="Photo 5">
                        <img src="assets/images/slider-5.png" class="img-fluid" alt="Photo 5">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="photo6.jpg" data-toggle="lightbox" data-title="Photo 6">
                        <img src="assets/images/slider-1.png" class="img-fluid" alt="Photo 6">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="aboutUs" id="about_us">
        <div class="container p-5">
            <h2 class="text-center mt-5">About Us</h2>
            <div class="row">
                <div class="col-md-4">
                    <p>We are a team of dedicated professionals who are passionate about our work. Our mission is to
                        provide high-quality services and products to our clients, while also maintaining a strong
                        commitment to sustainability and social responsibility.</p>
                    <p>With years of experience in the industry, we have built a reputation for excellence and are proud
                        to have a loyal customer base. Our team is constantly striving to improve and innovate, and we
                        are always looking for new ways to better serve our clients.</p>
                </div>
                <div class="col-md-4 about_us_border d-flex">
                    <img src="assets/images/logo-small.png" class="my-5 mx-auto" alt="">
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="container mb-5">
                            <h5 class="text-center">Contact Us</h5>
                            <form>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" id="message" rows="3"
                                        placeholder="Enter your message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/jquery-3.6.3.min.js"></script>
    <script src="assets/bootstrap/js/popper.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap/script.js"></script>
    <script src="assets/bootstrap/common.js"></script>
</body>
</html>