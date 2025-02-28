<div class="blog">

    <div class="container">

        <div class="blog-container has-scrollbar" id="BlogsCard">

        </div>
        <a href="#" style="text-align: right">See All</a>
    </div>

</div>

<script>
    getBlogs()
    async function getBlogs(){
        let res = await axios.get('blogs-card');

        // console.log(res);
        document.getElementById("BlogsCard").innerHTML = '';

        // Loop through the first batch of new arrivals and append to #newArrivals
        res.data.forEach(function(item) {
            const createdAt = new Date(item.created_at);
            const formattedDate = createdAt.toLocaleString('en-GB', {
                timeZone: 'Asia/Dhaka',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
            let div = `
                <div class="blog-card">

                    <a href="#">
                        <img src="${item['image']}"
                            alt="Clothes Retail KPIs 2021 Guide for Clothes Executives" width="300"
                            class="blog-banner">
                    </a>

                    <div class="blog-content">

                        <a href="#" class="blog-category" style="color: #22bfbf;">${item['name']}</a>

                        <a href="#">
                            <h3 class="blog-title">${item['title']}</h3>
                        </a>

                        <p class="blog-meta">
                            By <cite>${item['publisher']}</cite> / <time datetime="2022-04-06">${formattedDate}</time>
                        </p>

                    </div>

                </div>
            `;

            // Append the constructed HTML to the #newArrivals element
            document.getElementById("BlogsCard").innerHTML += div;
        });
    }
</script>
