<div class="banner">

    <div class="container">
        <div class="slider-container has-scrollbar" id="productBanner">
            
        </div>
    </div>

</div>
@push('custom-scripts')
<script>
    getBanner()

    async function getBanner(){
        showLoader()
        let resbanner = await axios.get("product-banner");
        hideLoader()       

        resbanner.data.forEach(function(item) {
            let div = `
                <div class="slider-item">

                <img src="${item['image']}" alt="women's latest fashion sale"
                    class="banner-img">

                <div class="banner-content">

                    <p class="banner-subtitle" style="color: rgb(212, 132, 11);">${item['title']}</p>

                    <h2 class="banner-title">${item['short_des']}</h2>

                    <p class="banner-text">
                        starting at &dollar; <b>${item['price']}</b>
                    </p>

                    <a href="#" class="banner-btn" style="background-color: rgb(212, 132, 11);">Shop now</a>

                </div>

            </div>
            `;
            // Use innerHTML to append the string as HTML
            document.getElementById('productBanner').innerHTML += div;
        });
        // console.log(resbanner)
    }
</script>
@endpush