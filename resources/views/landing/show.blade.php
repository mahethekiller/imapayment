@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $lp->title }}</h1>
  <p>{{ $lp->description }}</p>

  <form id="regForm" method="POST" action="{{ route('lp.register', $lp->slug) }}">
    @csrf
    <input type="hidden" name="type" id="type" value="{{ auth()->check() ? 'member' : 'guest' }}">

    <div>
      <label>Name</label><input name="name" required>
      <label>Email</label><input name="email" type="email" required>
      <label>Mobile</label><input name="mobile">
      <label>Company</label><input name="company">
      <label>Country</label><input name="country">
      <label>City</label><input name="city">
      <label>Address</label><textarea name="address"></textarea>
      <label>Company GST</label><input name="company_gst">
      <label>Preferred City</label><input name="preferred_city">
    </div>

    <hr>
    <h4>Extra Members</h4>
    <div id="extra-members">
      <!-- extra member template will be appended here -->
    </div>
    <button type="button" id="addExtra">Add Extra Member</button>

    <hr>
    <div>
      <p>Base (Member): <span id="memberPrice">{{ number_format($lp->member_price, 2) }}</span></p>
      <p>Base (Non-member): <span id="nonMemberPrice">{{ number_format($lp->non_member_price, 2) }}</span></p>
      <p>GST: <span id="gstPercent">{{ number_format($lp->gst_percent, 2) }}%</span></p>
      <p>Discount: <span id="discountAmount">0.00</span></p>
      <p>Total: <b id="finalAmount">0.00</b></p>
    </div>

    <button type="submit">Pay Now</button>
  </form>
</div>

<script>
const lp = {
  member_price: parseFloat(@json($lp->member_price)),
  non_member_price: parseFloat(@json($lp->non_member_price)),
  gst_percent: parseFloat(@json($lp->gst_percent)),
  discountRules: @json($lp->discountRules)
};

let isMember = {!! auth()->check() ? 'true' : 'false' !!};
document.getElementById('type').value = isMember ? 'member' : 'guest';

function calculate() {
  const extraCount = document.querySelectorAll('.extra-member').length;
  const base = isMember ? lp.member_price : lp.non_member_price;
  const gst = +(base * (lp.gst_percent / 100));
  let total = base + gst;
  let discount = 0;

  // apply discountRules (simple mimic of server behavior)
  lp.discountRules.forEach(rule => {
    if (!rule.active) return;
    if (rule.type === 'flat_percent') {
      discount += total * (rule.value/100);
    } else if (rule.type === 'extra_member_threshold' && extraCount > (rule.threshold || 0)) {
      discount += total * (rule.value/100);
    }
  });

  total = Math.max(0, total - discount);
  document.getElementById('discountAmount').innerText = discount.toFixed(2);
  document.getElementById('finalAmount').innerText = total.toFixed(2);

  // set hidden fields so server can use same values if needed
  // (We rely on server calc for authoritative values)
}

document.getElementById('addExtra').addEventListener('click', function(){
  const wrapper = document.createElement('div');
  wrapper.className = 'extra-member';
  wrapper.innerHTML = `
    <input name="extra_members[][name]" placeholder="Name" required>
    <input name="extra_members[][email]" placeholder="Email">
    <input name="extra_members[][phone]" placeholder="Phone">
    <button type="button" class="remove">Remove</button>
  `;
  wrapper.querySelector('.remove').addEventListener('click', () => { wrapper.remove(); calculate(); });
  document.getElementById('extra-members').appendChild(wrapper);
  calculate();
});

document.addEventListener('change', calculate);
calculate();
</script>
@endsection
