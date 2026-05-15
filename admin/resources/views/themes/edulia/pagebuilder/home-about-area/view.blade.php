<!-- ABOUT SECTION START -->
<section class="about_us">
    <div class="container">
        <div class="row align-items-center">

            <!-- Images -->
            <div class="col-md-6">
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
            <div class="col-md-6">
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
<!-- ABOUT SECTION END -->

<!-- CSS -->
<style id="about-final-css">
.about_us {
    padding: 80px 0;
    background: #f9f9f9;
}

/* Images */
.about_us .about_us_img {
    display: flex;
    gap: 15px;
}

.about_us .about_us_img img {
    width: 100%;
    border-radius: 10px;
    object-fit: cover;
}

.about_us .left-images {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 50%;
}

.about_us .right-image {
    width: 50%;
}

/* Content */
.about_us .about_us_inner h3 {
    font-size: 32px;
    margin-bottom: 15px;
    color: #1a237e;
    font-weight: 700;
}

.about_us .about_us_inner p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

/* List */
.about_us .about_list {
    margin-top: 25px;
}

.about_us .about_item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.about_us .about_icon {
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

.about_us .about_text h4 {
    margin: 0;
    font-size: 18px;
    color: #222;
}

.about_us .about_text p {
    margin: 5px 0 0;
    font-size: 14px;
    color: #666;
}

/* Responsive */
@media (max-width: 768px) {
    .about_us .about_us_img {
        flex-direction: column;
    }

    .about_us .left-images,
    .about_us .right-image {
        width: 100%;
    }
}
</style>