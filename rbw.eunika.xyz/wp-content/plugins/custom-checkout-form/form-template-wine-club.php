<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjPq8yGs4GGN3lheKONjn8JkwVIR8Lo_s&libraries=places"></script>

<div class="container">
  <form id="billing-shipping-form">

    <!-- Step 1: Membership Information -->
    <div id="fillup-step-1">
      <h2>You're Just One Step Away from Joining Our Exclusive Wine Club!</h2>
      <p>Fill in your membership details to start enjoying amazing wines delivered to your door.</p>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="billing_first_name">First Name</label>
          <input type="text" class="form-control" id="billing_first_name" placeholder="John" required>
        </div>
        <div class="form-group col-md-6">
          <label for="billing_last_name">Last Name</label>
          <input type="text" class="form-control" id="billing_last_name" placeholder="Doe" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="billing_email">Email Address</label>
          <input type="email" class="form-control" id="billing_email" placeholder="you@example.com" required>
        </div>
        <div class="form-group col-md-6">
          <label for="billing_phone">Phone Number</label>
          <input type="tel" class="form-control" id="billing_phone" placeholder="(555) 555-5555" required>
        </div>
      </div>

      <button type="button" class="btn btn-primary btn-block" id="next-step" disabled>Next: Shipping Details</button>
    </div>

    <!-- Step 2: Shipping Information -->
    <div id="fillup-step-2" style="display:none;">
      <h2>Shipping Details</h2>
      <p>No worries, your shipping address can be changed later if needed!</p>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="shipping_first_name">First Name</label>
          <input type="text" class="form-control" id="shipping_first_name" placeholder="John" required>
        </div>
        <div class="form-group col-md-6">
          <label for="shipping_last_name">Last Name</label>
          <input type="text" class="form-control" id="shipping_last_name" placeholder="Doe" required>
        </div>
      </div>

      <div class="form-group">
        <label for="shipping_address_1">Address</label>
        <input type="text" class="form-control autocomplete-address" id="shipping_address_1" placeholder="1234 Main St" required>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="shipping_city">City</label>
          <input type="text" class="form-control autocomplete-city" id="shipping_city" placeholder="New York" required>
        </div>
        <div class="form-group col-md-4">
          <label for="shipping_state">State</label>
          <input type="text" class="form-control autocomplete-state" id="shipping_state" placeholder="NY" required>
        </div>
        <div class="form-group col-md-2">
          <label for="shipping_postcode">ZIP</label>
          <input type="text" class="form-control autocomplete-zip" id="shipping_postcode" placeholder="10001" required>
        </div>
      </div>

      <div class="form-group">
        <label for="shipping_country">Country</label>
        <select id="shipping_country" class="form-control" required>
          <option value="US" selected>United States</option>
          <!-- Add more country options as needed -->
        </select>
      </div>

      <div class="d-flex flex-column flex-md-row justify-content-between">
        <button type="button" class="btn btn-secondary mb-2 mb-md-0" id="back-step">Back to Membership</button>
        <button type="submit" class="btn btn-flat-maroon">Claim My Membership</button>
      </div>

    </div>

  </form>
</div>
