<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - Deep Ganga Public School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }

        .section_padding {
            padding: 80px 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .col-6 {
            width: 50%;
            padding: 15px;
        }

        @media (max-width: 768px) {
            .col-6 {
                width: 100%;
            }
        }

        /* Image Section */
        .about_us_img {
            display: flex;
            gap: 15px;
        }

        .about_us_img img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .left-images {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 50%;
        }

        .right-image {
            width: 50%;
        }

        /* Text Section */
        .about_us_inner h3 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #1a237e;
        }

        .about_us_inner p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        /* Features List */
        .about_list {
            margin-top: 25px;
        }

        .about_item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .about_icon {
            width: 40px;
            height: 40px;
            background: #1a237e;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
            font-weight: bold;
        }

        .about_text h4 {
            margin: 0;
            font-size: 18px;
            color: #222;
        }

        .about_text p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

<!-- ABOUT SECTION -->
<section class="section_padding about_us">
    <div class="container">
        <div class="row">

            <!-- Images -->
            <div class="col-6">
                <div class="about_us_img">
                    <div class="left-images">
                        <img src="https://images.unsplash.com/photo-1588072432836-e10032774350" alt="School Image">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754" alt="Students">
                    </div>
                    <div class="right-image">
                        <img src="https://images.unsplash.com/photo-1596495578065-6e0763fa1178" alt="Classroom">
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-6">
                <div class="about_us_inner">
                    <h3>About Deep Ganga Public School</h3>
                    <p>
                        Deep Ganga Public School is committed to providing quality education that nurtures
                        creativity, discipline, and leadership. We focus on holistic development to prepare
                        students for future challenges.
                    </p>

                    <div class="about_list">

                        <div class="about_item">
                            <div class="about_icon">1</div>
                            <div class="about_text">
                                <h4>Experienced Faculty</h4>
                                <p>Highly qualified teachers dedicated to student success.</p>
                            </div>
                        </div>

                        <div class="about_item">
                            <div class="about_icon">2</div>
                            <div class="about_text">
                                <h4>Modern Infrastructure</h4>
                                <p>Smart classrooms and advanced learning facilities.</p>
                            </div>
                        </div>

                        <div class="about_item">
                            <div class="about_icon">3</div>
                            <div class="about_text">
                                <h4>Holistic Development</h4>
                                <p>Focus on academics, sports, and extracurricular activities.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

</body>
</html>