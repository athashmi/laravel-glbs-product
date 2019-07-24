@extends('frontend.layouts.main')
@section('content')
<div class="page-title">
   <div class="container">
      <div class="column">
         <h1>Help / FAQ</h1>
      </div>
      <div class="column">
         <ul class="breadcrumbs">
            <li><a href="index.html">Home</a>
            </li>
            <li class="separator">&nbsp;</li>
            <li>Help / FAQ</li>
         </ul>
      </div>
   </div>
</div>
<!-- Page Content adnan hussain-->
<div class="container padding-bottom-3x" style="margin-top:4%">
  <div class="text-center">
     <h1 style="text-transform:uppercase">frequently asked <span style="color:#25B788">questions</span></h1>
  </div>
   <div class="row faq_row">
      <!-- Side Menu-->
      <!-- <div class="col-lg-3 col-md-4">
         <nav class="list-group"><a class="list-group-item active" href="#">Most Popular Questions</a><a class="list-group-item" href="#">Managing Account</a><a class="list-group-item" href="#">Working With Dashboard</a><a class="list-group-item" href="#">Available Payment Methods</a><a class="list-group-item" href="#">Delivery Information</a><a class="list-group-item" href="#">Order Tracking Instructions</a><a class="list-group-item" href="#">Refund Policy</a><a class="list-group-item" href="#">Offers And Discounts</a><a class="list-group-item" href="#">Reward Points</a><a class="list-group-item" href="#">Affiliate Program</a><a class="list-group-item" href="#">Service Terms &amp; Conditions</a></nav>
         <div class="padding-bottom-3x hidden-md-up"></div>
         </div> -->
      <!-- <div class="col-lg-3">
         <nav class="list-group"><a class="list-group-item active" href="#">Most Popular Questions</a><a class="list-group-item" href="#">Managing Account</a><a class="list-group-item" href="#">Working With Dashboard</a><a class="list-group-item" href="#">Available Payment Methods</a><a class="list-group-item" href="#">Delivery Information</a><a class="list-group-item" href="#">Order Tracking Instructions</a><a class="list-group-item" href="#">Refund Policy</a><a class="list-group-item" href="#">Offers And Discounts</a><a class="list-group-item" href="#">Reward Points</a><a class="list-group-item" href="#">Affiliate Program</a><a class="list-group-item" href="#">Service Terms &amp; Conditions</a></nav>
         <div class="padding-bottom-3x hidden-md-up"></div>
      </div> -->
      <div class="col-md-12 custom-faq">
         <h6>SHOPAHOLICS</h6>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
                     Who are Shopaholics?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapseOne" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Shopaholics are users who can buy almost anything they want, from wherever! We will ship the order right to their doorstep, it doesn't matter where they live.* *Note: We do not conduct any type of transactions whatsoever (shipping, business, payment etc.) with the following countries: Cuba, Iran, Myanmar, North Korea, Sudan and Syria.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse2" data-toggle="collapse" data-parent="#accordion">
                     How do I sign up to become a Shopaholic?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse2" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Anyone from anywhere in the world can become a Shopaholic. It is totally free and really easy. Navigate to the Registration page and enter your information. Once you are done, you will receive an email from us to verify your account. After verifying your account, you can log in for the first time. Upon first login you will be asked to enter your complete shipping address. *Note: We do not conduct any type of transactions whatsoever (shipping, business, payment etc.) with the following countries: Cuba, Iran, Myanmar, North Korea, Sudan and Syria.
                        <br><br>
                        NOTE: Please provide the same shipping address associated with your credit card or bank account. In other words, your shipping and billing address must much. We verify your address with your selected method of payment and only ship to the address that is linked to that method of payment.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse3" data-toggle="collapse" data-parent="#accordion">
                     Can I shop from International Online Stores based outside the US?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse3" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Yes, all you need to do is submit a Shopper Purchase in the country your Online Store is located. Provide all necessary information including direct URL links to the items you are requesting. A Shopper will purchase and recieve items on your behalf and ship them to you. We hold your payment until you confirm you have recieved the order. Once confirmed, we release funds to the Shopper. *Note: We do not conduct any type of transactions whatsoever (shipping, business, payment etc.) with the following countries: Cuba, Iran, Myanmar, North Korea, Sudan and Syria.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse4" data-toggle="collapse" data-parent="#accordion">
                     How many items can I purchase per request?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse4" role="tabpanel">
                  <div class="card-body">
                     <p>
                        There is no limit to the amount of items you can purchase per request.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse5" data-toggle="collapse" data-parent="#accordion">
                     Can you consolidate my packages into one package?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse5" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Yes, we can consolidate all of your packages in one box to save you shipping charges, your savings are very important to us.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse6" data-toggle="collapse" data-parent="#accordion">
                     Can you repack my items in a SMALLER BOX?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse6" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Yes, we understand that companies ship in large boxes, to save you money on shipping we will repack your items into the smallest box possible without compromising safety and damage of your items.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse7" data-toggle="collapse" data-parent="#accordion">
                     What is the Customs and Insurance value in Consolidate and Ship Request Form?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse7" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Customs Value: This is the value that we put on the Commercial Invoice, it is the value your customs Agency will assess and determine wheather or not customs is due on the items being imported. It is also your responsibility to put determine this value, we simply put whatever you tell us to put. Example in United States, personal items exceeding $800 will be charged customs tax. If the value is less than $800, we dont have to pay customs in the United States. It is your responsibility to know how your Local Customs Agency works and what they charge.
                        <br><br>
                        Insurance Value: If you want to insure your package through the Shipping Carrier, your package will only be insured up to the value you put in this field. The reason both Customs and Insurance value share the same field is becasue they have to be the same. You cannot claim that your package is only worth $10 to Customs Agency and then claim insurance for $100 if your package is damaged.
                        <br><br>
                        ***The published shipping rates are for door-to-door delivery. You may also be liable for tax and import duty and this differs from country to country. Many countries have a duty free concession where goods below a certain value can be imported without duty and/or tax. You should reference each country's local customs department for more information on duties or import fees. This is your responsibility.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse8" data-toggle="collapse" data-parent="#accordion">
                     How does my Wallet work?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse8" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We take customer satisfaction very seriously. That's why as soon as you place a order, The total amount of the order appears in your personal wallet and remains there until your order is shipped.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse9" data-toggle="collapse" data-parent="#accordion">
                     What does Estimated Cost mean in my Wallet?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse9" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Estimated Cost is based on the item costs and measurements you entered while placing the order. We call this cost 'Estimated' because it may change depending on the actual cost of the item or the actual weight and dimensions of your package especially if your package was consolidated/combined with another order.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse10" data-toggle="collapse" data-parent="#accordion">
                     What does Actual Cost mean in my Wallet?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse10" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Actual cost is the final cost determined by our shipping team.
                        <br><br>
                        1. If the Actual Cost is less than the Estimated Cost, your wallet will be credited with the difference and you can use this credit when placing your next order or you can withdraw it to your bank account.
                        <br>
                        2. If the Actual Cost is more than the Estimated Cost, your wallet balance will go to negative and will show as "Balance Due". You will recieve a notifcation to pay this balance immediatly. Please pay the balance as soon as possible to avoid any delays.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse11" data-toggle="collapse" data-parent="#accordion">
                     Why is my Wallet showing Negative balance?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse11" role="tabpanel">
                  <div class="card-body">
                     <p>
                        There are only two reasons why your wallet may show a Negative balance:
                        <br>
                        1. Actual price of your requested items is different than what was entered in the form.<br>
                        2. While calculating the shipping costs, the weight or dimensions you entered on the form are different than the actual weight or dimensions.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse12" data-toggle="collapse" data-parent="#accordion">
                     What kind of protection do you offer when dealing with Shoppers?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse12" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We offer Shopaholic Protection along with all of your purchases. When you pay for your requested items, you pay us, not the Shopper. We hold your funds until you recieve your requested products. As soon as we get confirmatin that you recieved your items, we release the funds to the corresponding Shopper. All shipments are tracked and verified by our carrier so we know what is on its way and when it arrives at your doorstep. If your package gets lost or damaged, we claim insurance on your behalf through the shipper.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse13" data-toggle="collapse" data-parent="#accordion">
                     Why can I no longer message the Shopper I was working with?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse13" role="tabpanel">
                  <div class="card-body">
                     <p>
                        You can only send messages to Shoppers you are 'connected' with. Connections are made as soon as a Shopper submits an offer to you but are terminated once you complete the order by marking the Purchase Request as recieved in our system.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse14" data-toggle="collapse" data-parent="#accordion">
                     What kinds of things am I NOT allowed to buy?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse14" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Please check before you shop. Due to US export regulations and carrier restrictions, we are not able to export certain items. Before you buy items from the USA or other countries, please be sure they are not on our "Do not Purchase List":.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse15" data-toggle="collapse" data-parent="#accordion">
                     What can I do if a merchant requires me to have US debit card with US billing address?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse15" role="tabpanel">
                  <div class="card-body">
                     <p>
                        To get you what you want, we have also introduced Assisted and Shopper Purchase requestS. We or our Shopper will buy the item for you.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse16" data-toggle="collapse" data-parent="#accordion">
                     Should I notify Global Shopaholics of any incoming packages?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse16" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Although it is not a requirment, we recommend you fill out Incoming Package form. It is a very short 3 step form.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse17" data-toggle="collapse" data-parent="#accordion">
                     Does Global Shopaholics provide insurance if something happens with my item?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse17" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Insurance is available via DHL and USPS. Aramex will only cover up to $100. Please Contact us for any claims .
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse18" data-toggle="collapse" data-parent="#accordion">
                     What is a Direct Purchase?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse18" role="tabpanel">
                  <div class="card-body">
                     <p>
                        A Direct Purchase allows you to Purchase products from any US Online store using your own payment method and ship them directly to our warehouse. .
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse19" data-toggle="collapse" data-parent="#accordion">
                     What is a Assisted Purchase?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse19" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Not all US online stores allow you to use foreign credit cards on their websites and some require you to have a US Billing address, for this scenerio we have created Assisted Purchase. Simply fill out the Assited Purchase Request form and let us know what you would like us to purchase on your behalf. We will purchase and receive the requested items for you and forward them to your international address.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse20" data-toggle="collapse" data-parent="#accordion">
                     What phone number should I use when placing an online order?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse20" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Some online stores will ask for a US phone number. Do not place our phone number otherwise your order would be most probably cancelled which is because if the seller receives several orders on different names and credit cards but with the same phone number their system could detect it as a risky order so you need to place your own phone number. You can get a US phone number with many online services.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse21" data-toggle="collapse" data-parent="#accordion">
                     How many items can I purchase per request?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse21" role="tabpanel">
                  <div class="card-body">
                     <p>
                        You can purchase up to 5 items per Purchase Request.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <h6>SHOPPERS</h6>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse22" data-toggle="collapse" data-parent="#accordion">
                     Who are Shoppers?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse22" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Shoppers are trusted people, all over the world. They know where to shop and where to find good deals. They will physically purchase requested items for you and ship them to your address with trust.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse23" data-toggle="collapse" data-parent="#accordion">
                     How can I register to become a Shopper?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse23" role="tabpanel">
                  <div class="card-body">
                     <p>
                        To become a Shopper, please follow the registration process below:
                        <br>
                        <br>
                        1. Register for a Shopper account.<br>
                        2. After you complete your registration, we will contact you via email and send you an application form.<br>
                        3. Complete the application form and email it back to us along with your Government or School Issued Photo ID.<br>
                        (if you do not have a scanner, a picture of your ID is acceptable)<br>
                        4. After reviewing your application, we will schedule a Skype interview with you.<br>
                        5. Once we approve your application, we will send you an email containing an activation link. Follow the link to activate your Shopper account.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse24" data-toggle="collapse" data-parent="#accordion">
                     How do I send a picture via Messages?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse24" role="tabpanel">
                  <div class="card-body">
                     <p>
                        You have to embed the image in an html tag in order to send it via our Messaging tool. To do so, please perform the following steps:
                        <br>
                        <br>
                        1. Upload the image to a image sharing website like flickr or facebook.
                        2. Once uploaded, right click on the image and copy the URL of the image (usually called Copy Image Location in the right click menu)
                        Example: https://scontent-iad3-1.xx.fbcdn.net/t31.0-8/13072685_609942852507913_9160998194657503929_o.jpg
                        <br>
                        <br>
                        3. Paste the URL of the image in the following tag: <img src="URL goes here" width="300px">
                        Example: <img src="https://scontent-iad3-1.xx.fbcdn.net/t31.0-8/13072685_609942852507913_9160998194657503929_o.jpg" width="300px">
                        <br>
                        <br>
                        4. Finally, copy and paste the entire tag into the message and send it.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse25" data-toggle="collapse" data-parent="#accordion">
                     What are my payment withdraw options?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse25" role="tabpanel">
                  <div class="card-body">
                     <p>
                        As a Shopper, you are required to have a Bank Account. When you submit a withdraw request, we will send a direct deposit/wire transfer to your bank account.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse26" data-toggle="collapse" data-parent="#accordion">
                     When can I withdraw money from my wallet?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse26" role="tabpanel">
                  <div class="card-body">
                     <p>
                        You can only withdraw money from your "Cleared Balance". Your wallet balance will clear for corresponding purchase requests when the Shopaholic Marks the order as recieved in our system. To understand in detail how your wallet works please visit our How It Works section.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse27" data-toggle="collapse" data-parent="#accordion">
                     Why can I no longer message the Shopaholic I was working with?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse27" role="tabpanel">
                  <div class="card-body">
                     <p>
                        You can only send messages to Shopaholics you are 'connected' with. Connections are made as soon as you submit an offer but are terminated once you complete the order and the Shopaholic marks their items as recieved.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <h6>PAYMENTS</h6>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse28" data-toggle="collapse" data-parent="#accordion">
                     What modes of payment are acceptable?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse28" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Currently, the following are the available modes of payment:
                        - Credit/Debit Cards - from all over the world <br>
                        - PayPal<br>
                        - BitCoin<br>
                        - Bank Wire Transfer<br>
                        - TransferWise<br>
                        - Cash (offered only in some countries)<br>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse29" data-toggle="collapse" data-parent="#accordion">
                     How can I send a Bank Wire Transfer?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse29" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We charge $16 incoming wire transfer fee. We recommend wire transfers for orders over $372 to save you money.
                        <br>
                        <br>
                        To send a Bank Wire Transfer to Global Shopahlics, please make sure you reference your Request ID and use the following bank account details:
                        <br>
                        <br>
                        Name: GLOBAL SHOPAHOLICS LLC
                        Account name: GLOBAL SHOPAHOLICS LLC
                        Account number: Provided during checkout when submitting Offline Payment.
                        Routing number: 2540701162
                        SWIFT: CITI US 33
                        Bank info: Citibank
                        Address: 14175 St Germain Dr, Centreville, VA 20121
                        <br>
                        <br>
                        Note: We do not provide an IBAN number as it is not used by U.S. banks.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse30" data-toggle="collapse" data-parent="#accordion">
                     Is there a spending limit on accounts?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse30" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We do not have spending limits but if you spend more than $500 on a single request it will be held for a longer period of time. We cannot purchase requested items until your payment clears our Bank. To avoid delays when spending more than $500, please use BitCoin, Transferwise or Bank Wire Transfer.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse31" data-toggle="collapse" data-parent="#accordion">
                     Are there any hidden fees?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse31" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We are up front about all of our fees, no hidden charges.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <h6>SHIPPING</h6>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse32" data-toggle="collapse" data-parent="#accordion">
                     What Items are prohibited or restricted for Shipping?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse32" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We cannot ship any items considered as Dangerous Goods including Perfume or cologne which is considered as a flammable liquid via ARAMEX or USPS.
                        <br>
                        <br>
                        Aramex Prohibited Items: Please refer to following document for Prohibited and Restricted Items when shipping with Aramex: Click Here.
                        <br>
                        <br>
                        DHL Prohibited Items: Please refer to following document for Prohibited and Restricted Items when shipping with DHL: Click Here.
                        <br>
                        <br>
                        We are a certified Dangerous Goods Shipper with DHL. We can Ship batteries and Perfume/Cologne products.
                        <br>
                        <br>
                        Shipping Perfume/Cologne via DHL: Any Perfume/Cologne product containing less than 30ML liquid can be shipped without additional charge. If your Cologne/Perfume bottles contain more than 30ML liquid then you will be assessed an addtional $94 charge by DHL. This is not our charge, this is what DHL charges to handle this type of product because it is a flammable liquid.
                        <br>
                        <br>
                        Shipping Batteries via DHL: Please contact us at help@globalshopaholics.com regarding the battery product you are interested in shipping and we will let you know if allowed to be shipped or not. This particular category is heavly regulated.
                        <br>
                        <br>
                        Besides what is listed above, you are responsible for knowing what types of products your country allows for Import. We will not be responsibale if your shipment is rejected due to import restrictions imposed by your country.
                        <br>
                        <br><br>
                        <br>
                        PLEASE ALSO REVIEW QUESTION BELOW REGARDING ITEMS ON OUR DO NOT SHIP LIST:
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse33" data-toggle="collapse" data-parent="#accordion">
                     What Items are on your DO NOT SHIP LIST?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse33" role="tabpanel">
                  <div class="card-body">
                     <p>
                        This is our General Do Not SHIP LIST, Please review before making any purchases:
                        <br><br>
                        - Firearms or Firearm parts, or parts of any weapons. Firearms, guns & accessories, including replicas
                        <br><br>
                        - Prescription medications, including dental & veterinary
                        <br><br>
                        - Prescription medical devices
                        <br><br>
                        - Medical devices not FDA-approved
                        <br><br>
                        - Prohormones, Human Growth Hormones, stem cell treatments, steroids or synthetic versions
                        <br><br>
                        - The following items that are not labeled in English, or without FDA-approved labeling requirements: Non-prescription medications, Dietary supplements, Cosmetics, Food
                        <br><br>
                        - Any food, supplement, drug or cosmetic that has been issued a Consumer Safety Advisory Warning
                        <br><br>
                        - Perishable products of any kind
                        <br><br>
                        - Lab reagents, biologics, cultures, medical specimens
                        <br><br>
                        - Poisonous substances
                        <br><br>
                        - Toxic substances, including inhalation hazards
                        <br><br>
                        - Infectious substances
                        <br><br>
                        - Explosives, fireworks, gun powder, flares or matches
                        <br><br>
                        - Gasoline, diesel or other fuels
                        <br><br>
                        - Lighters containing fuel
                        <br><br>
                        - Meals Ready to Eat (MRE)
                        <br><br>
                        - Pesticides, herbicides, fungicides
                        <br><br>
                        - Radioactive elements or products
                        <br><br>
                        - Self-balancing boards (hoverboards)
                        <br><br>
                        - Oxidizing agents
                        <br><br>
                        - Fire extinguishers
                        <br><br>
                        - BB/pellet/airsoft/paintball guns, parts and projectiles
                        <br><br>
                        - Ammunition, magazines & bayonets
                        <br><br>
                        - Stun guns & tasers
                        <br><br>
                        - Tear gas, mace & pepper spray
                        <br><br>
                        - Gas masks & gas mask filters
                        <br><br>
                        - Law enforcement striking weapons, including saps, batons & billy clubs
                        <br><br>
                        - Handcuffs of any material, including plastic zip tie restraints & straitjackets
                        <br><br>
                        - Body armor, helmets or personal protection articles with kevlar or ballistic ratings
                        <br><br>
                        - Military/tactical/police shields
                        <br><br>
                        - Government, police or military uniforms, IDs and Badges (real or replica)
                        <br><br>
                        - Military training equipment
                        <br><br>
                        - Military and/or dual-use flight helmets and flight jumpsuits
                        <br><br>
                        - Military and law enforcement equipment
                        <br><br>
                        - Thermal imaging, InfraRed or other night vision devices
                        <br><br>
                        - Rifle scopes, laser pointing & aiming devices for firearms
                        <br><br>
                        - Defense articles controlled under the US Munitions List as defined under the International Traffic in Arms Regulations
                        <br><br>
                        - Self-propelled vehicles
                        <br><br>
                        - Damaged batteries
                        <br><br>
                        - Any dual-use or commercial article controlled under the Commerce Control List (CCL) as defined under the Export Administration Regulations, where the control status requires a Bureau of Industry and Security (BIS) approved export license
                        <br><br>
                        - Counterfeit products
                        <br><br>
                        - Contraband or illegal substances
                        <br><br>
                        - Lottery tickets
                        <br><br>
                        - Gambling devices & accessories
                        <br><br>
                        - Lock picking devices
                        <br><br>
                        - Rough diamonds
                        <br><br>
                        - Live or dead animals or insects
                        <br><br>
                        - Human remains
                        <br><br>
                        - Coral
                        <br><br>
                        - Brazilian rosewood
                        <br><br>
                        - Skin or leather of snakes, alligators, crocodiles, stingrays, and other reptiles or amphibians
                        <br><br>
                        - Skin, fur or leather of wolves, bears, elephants, rhinos and certain deer and foxes
                        <br><br>
                        - Sturgeon or Beluga caviar
                        <br><br>
                        - Agricultural products, including certain seeds, live or dead plants, unfinished or untreated wood & soil
                        <br><br>
                        - Items containing animal products controlled under the Endangered Species Act, Marine Mammal Protection Act, or requiring a permit under CITES
                        <br><br>
                        - Any unidentifiable material, substance or chemical
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse34" data-toggle="collapse" data-parent="#accordion">
                     How much does shipping cost and what does this cost include?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse34" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We offer affordable international shipping rates. Shipping costs vary from country to country, use our Quick Look Shipping Calculator to take a peak at our rates. A detailed calculator is available in our memebers section.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse35" data-toggle="collapse" data-parent="#accordion">
                     How long will it take for my order to arrive?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse35" role="tabpanel">
                  <div class="card-body">
                     <p>
                        This depends on the carrier and service you use and can range from 3 - 30 days. T We will provide shipping confirmation with your tracking number so you can follow your order while on it​'s​ way to you.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse36" data-toggle="collapse" data-parent="#accordion">
                     Do your shipping rates include customs fees, tariffs or taxes?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse36" role="tabpanel">
                  <div class="card-body">
                     <p>
                        The published shipping rates are for door-to-door delivery. You may also be liable for tax and import duty and this differs from country to country. Many countries have a duty free concession where goods below a certain value can be imported without duty and/or tax. You should reference each country's local customs department for more information on duties or import fees. This is your responsibility.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse37" data-toggle="collapse" data-parent="#accordion">
                     Which countries do you ship to?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse37" role="tabpanel">
                  <div class="card-body">
                     <p>
                        We currently ship to all countries EXCEPT the following:
                        - Cuba
                        <br>
                        - Myanmar
                        <br>
                        - North Korea
                        <br>
                        - Sudan
                        <br>
                        - Iran
                        <br>
                        - Syria
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse38" data-toggle="collapse" data-parent="#accordion">
                     How can I file an insurance claim for lost or damaged packages?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse38" role="tabpanel">
                  <div class="card-body">
                     <p>
                        Please contact help@globalshopaholics.com and put Insurance Claim in the Subject. If you received a damaged item, we will require photos so we can submit them to the shipping company. If item is damaged due to packaging you may be responsible in instances where if you request to put in very small box to reduce shipping costs. We will always accept your request because we are a facilitator though we DO NOT recommended this. Our customers are in full control and therefore they are sometimes themselves responsible.
                        <br>
                        <br>
                        If your insurance claim is accepted by the carrier, they will send a return shipping label and the product must be returned unused. Insurance is only covered for a maximum stated in Insurances and Customs field on your request. Shipping costs cannot be recovered unless you add them in to insurance and customs value.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <h6>RETURN POLICY</h6>
         <div class="accordion" id="accordion" role="tablist">
            <div class="card">
               <div class="card-header" role="tab">
                  <h6><a href="#collapse39" data-toggle="collapse" data-parent="#accordion">
                     What's your return policy?
                     </a>
                  </h6>
               </div>
               <div class="collapse" id="collapse39" role="tabpanel">
                  <div class="card-body">
                     <p>
                        For Assisted Purchases: We hope you love your purchase, however, If there is any reason you are not completely satisfied, we are happy to offer a refund of your merchandise cost within 30 days of your original order date. Our timeframe for returns is also dependent upon the vendors return policy. Example: if the vendor who supplied your items has a 14 day return policy, we may not be able to process your return. It can take that long for us to receive your items.
                        <br><br>
                        NOTE: You are responsible for paying for the return shipping label and any Bank Fees associated with processing your refund.
                        <br><br>
                        All returned items must be unused and in their original packaging. To begin the return process, please email help@globalshopaholics.com
                        <br><br>
                        For Direct Purchases: Returns will not be accepted.<br>
                        Due to the costs associated with global purchases, the following fees are non-refundable:<br>
                        - Processing Fees<br>
                        - Shipping charges<br>
                        - Bank Fee <br>
                        <br>
                        <br>
                        If you ha​ve received a defective or damaged item​, simply send a photo to help@globalshopaholics.com
                        We look forward to hearing from you!
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
