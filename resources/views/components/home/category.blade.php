<div class="category">
    <div class="container">
        <div class="category-item-container has-scrollbar" id="categoryListHeader">
            <!-- Category items will be injected here -->
        </div>
    </div>
</div>

@push('custom-scripts')
<script type="text/javascript">
    getCategoryList();
    
    async function getCategoryList(){
        let resCategory = await axios.get("Category-header-list");
        resCategory.data.forEach(function(item) {
            let div = `
                <div class="category-item">
                    <div class="category-img-box">
                        <img src="${item['categoryImg']}" alt="category image" width="30">
                    </div>

                    <div class="category-content-box">
                        <div class="category-content-flex">
                            <h3 class="category-item-title">${item['categoryName']}</h3>
                            <p class="category-item-amount">(53)</p>
                        </div>
                        <a href="/product-category/${item['categoryName']}" class="category-btn">Show all</a>
                    </div>
                </div>
            `;
            // Use innerHTML to append the string as HTML
            document.getElementById('categoryListHeader').innerHTML += div;
        });
    }
</script>
@endpush
