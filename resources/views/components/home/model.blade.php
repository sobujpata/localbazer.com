<!--- MODAL-->
<div class="modal-notification" data-modal>

    <div class="modal-notification-close-overlay" data-modal-overlay></div>

    <div class="modal-notification-content">

        <button class="modal-notification-close-btn" data-modal-close>
            <ion-icon name="close-outline"></ion-icon>
        </button>

        <div class="newsletter-img">
            <img src="" alt="subscribe newsletter" width="400" height="400" id="noticeImage">
            {{-- <img src="{{asset('images/news.jpg')}}" alt="subscribe newsletter" width="400" height="400"> --}}
        </div>

        <div class="newsletter">

            <form action="#">

                <div class="newsletter-header">

                    <h3 class="newsletter-title">Subscribe Newsletter.</h3>

                    <p class="newsletter-desc">
                        Subscribe the <b>It Solution One Of The Best Solution</b> to get latest products and discount update.
                    </p>

                </div>

                <input type="email" name="email" class="email-field" placeholder="Email Address" required>

                <button type="submit" class="btn-newsletter">Subscribe</button>

            </form>

        </div>

    </div>

</div>
<script>
    getNotification()

    async function getNotification(){
        let res = await axios.get('/notification');
        document.getElementById('noticeImage').src=res.data['image'];
        console.log(res);
    }
</script>