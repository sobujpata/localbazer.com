  <!-- ==========================   -->
  <style>
    .element {
      display: inline-flex;
      align-items: center;
    }
    i.fa-camera {
      margin: 10px;
      cursor: pointer;
      font-size: 30px;
    }
    i:hover {
      opacity: 0.6;
    }
    #profileImageUpdate {
      display: none;
    }
    </style>
  <div class="container mt-4">
    <div class="row">
      <div class="col-xl-4">
        <!-- Profile picture card-->
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Profile Picture</div>
          <div class="card-body text-center">
            <!-- Profile picture image-->
            <img class="img-account-profile rounded-circle mb-2 w-100 ratio-1x1"
              src="" alt=""
              style="margin-left: auto; margin-right: auto; aspect-ratio: 1 / 1;" id="profileImage">

              <div class="element">
                <i class="fa fa-camera"></i>
                <form id="save-form">
                <input type="file" name="" id="profileImageUpdate" oninput="profileImage.src=window.URL.createObjectURL(this.files[0])">
              </div>
            <!-- Profile picture help block-->
            <div class="small font-italic text-muted mb-4"><b><span id="firstName"></span> <span id="lastName"></span></b></div>
            <!-- Profile picture upload button-->
            {{-- <button class="btn btn-primary" type="button">Upload Profile Picture</button> --}}
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <!-- Account details card-->
        <div class="card mb-4">
          <div class="card-header">Account Details</div>
          <div class="card-body">
            
              <div class="row gx-3 mb-3">
                <!-- Form Group (first name)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="inputFirstName">First name</label>
                  <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name"
                    value="">
                </div>
                <!-- Form Group (last name)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="inputLastName">Last name</label>
                  <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name"
                    value="">
                </div>
              </div>
              <!-- Form Row        -->
              <div class="row gx-3 mb-3">
                <!-- Form Group (organization name)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="address">Location</label>
                  <input class="form-control" id="address" type="text" placeholder="Enter your Location"
                    value="">
                </div>
                <!-- Form Group (location)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="postCode">Post Code</label>
                  <input class="form-control" id="postCode" type="text" placeholder="Enter your post code"
                    value="">
                </div>
                <div class="col-md-6 mt-3">
                  <label class="small mb-1" for="cus_city">City</label>
                  <input class="form-control" id="cus_city" type="text" placeholder="Enter your city"
                    value="">
                </div>
                <div class="col-md-6 mt-3">
                  <label class="small mb-1" for="cus_country">Country</label>
                  <input class="form-control" id="cus_country" type="text" placeholder="Enter your Country"
                    value="Bangladesh">
                </div>
              </div>
              <!-- Form Group (email address)-->
              <div class="mb-3">
                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address"
                  value="">
              </div>
              <!-- Form Row-->
              <div class="row gx-3 mb-3">
                <!-- Form Group (phone number)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="inputPhone">Phone number</label>
                  <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number"
                    value="">
                </div>
                <!-- Form Group (cus_fax)-->
                <div class="col-md-6 mt-3 mt-md-0">
                  <label class="small mb-1" for="inputFax">Fax Number <small class="text-sm">(If available.)</small></label>
                  <input class="form-control" id="inputFax" type="text" name="cus_fax"
                    placeholder="Enter your fax" value="">
                </div>
              </div>
              <!-- Save changes button-->
            </form>
            <button class="btn btn-primary" type="button" onclick="update()">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================= -->

  <script>
    $("i").click(function () {
      $("input[type='file']").trigger('click');
    });
    
    $('input[type="file"]').on('change', function() {
      var val = $(this).val();
      $(this).siblings('span').text(val);
    })
    getProfile()
    async function getProfile(){
        let res = await axios.get('/customer-profile');

        // console.log(res.data)

        let profileImage = document.getElementById('profileImage');
        if (profileImage) {
            profileImage.src = res.data?.profile?.image_url || "images/avater.jpeg";
        } else {
            console.error("Profile image element not found.");
        }
        document.getElementById('inputFirstName').value=res.data['firstName'];
        document.getElementById('firstName').innerHTML=res.data['firstName'];
        document.getElementById('lastName').innerHTML=res.data['lastName'];
        document.getElementById('inputLastName').value=res.data['lastName'];
        document.getElementById('address').value=res.data['profile']['cus_add'];
        document.getElementById('postCode').value=res.data['profile']['cus_postcode'];
        document.getElementById('cus_city').value=res.data['profile']['cus_city'];
        document.getElementById('cus_country').value=res.data['profile']['cus_country'];
        document.getElementById('inputEmailAddress').value=res.data['email'];
        document.getElementById('inputPhone').value=res.data['mobile'];
        document.getElementById('inputFax').value=res.data['profile']['cus_fax'];
    }

    async function update() {
        let firstName = document.getElementById('inputFirstName').value;
        let lastName = document.getElementById('inputLastName').value;
        let cus_add = document.getElementById('address').value;
        let cus_postcode = document.getElementById('postCode').value;
        let cus_city = document.getElementById('cus_city').value;
        let cus_country = document.getElementById('cus_country').value;
        let email = document.getElementById('inputEmailAddress').value;
        let mobile = document.getElementById('inputPhone').value;
        let cus_fax = document.getElementById('inputFax').value;
        let profileImage = document.getElementById('profileImageUpdate').files[0];

        // Required Field Validation
        if (!firstName) return errorToast("First Name is Required!");
        if (!lastName) return errorToast("Last Name is Required!");
        if (!cus_add) return errorToast("Address is Required!");
        if (!cus_postcode) return errorToast("Post Code is Required!");
        if (!cus_city) return errorToast("City is Required!");
        if (!cus_country) return errorToast("Country is Required!");
        if (!email) return errorToast("Email is Required!");
        if (!mobile) return errorToast("Mobile is Required!");

        let formData = new FormData();
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('cus_add', cus_add);
        formData.append('cus_postcode', cus_postcode);
        formData.append('cus_city', cus_city);
        formData.append('cus_country', cus_country);
        formData.append('email', email);
        formData.append('mobile', mobile);

        if (cus_fax) formData.append('cus_fax', cus_fax);
        if (profileImage) formData.append('profileImage', profileImage);

        try {
            showLoader();
            let res = await axios.post("/update-profile", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            hideLoader();
            if (res.status === 200) { // Changed from 201 to 200
                successToast('Profile updated Successfully!');
            } else {
                errorToast("Failed to Update Profile");
            }
        } catch (error) {
            hideLoader();
            if (error.response) {
                errorToast("Server Error: " + (error.response.data.message || "Please try again later"));
            } else {
                errorToast("An Error Occurred: " + error.message);
            }
        }
    }

</script>