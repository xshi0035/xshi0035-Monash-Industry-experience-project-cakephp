<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class ContentBlocksSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'Company Policies',
                'label' => 'Cancellation Policy',
                'description' => 'The cancellation policy customers have to accept before proceeding with a booking.',
                'slug' => 'cancellation-policy',
                'type' => 'html',
                'value' => '<strong>Cancellation policy*</strong>
                            <p class="mb-1">
                                No cancellations or changes allowed within 24 hours of the appointment.
                            </p>
                            <p class="mb-3">
                                $10 cancellation fee will be charged if appointment is cancelled less than 24 hours prior to the booking.
                            </p>',
            ],
            [
                'parent' => 'Company Policies',
                'label' => 'Terms & Conditions',
                'description' => 'Terms & Conditions customers have to accept before proceeding with a booking.',
                'slug' => 'terms-conditions',
                'type' => 'html',
                'value' => '<strong>Terms & Conditions*</strong>
                            <p class="mb-1">
                            The Supplier cannot guarantee, and hereby specifically excludes, any liability for any colour loss, colour bleeding, shrinkage, damage to weak and tender fabrics or components including aged or brittle plastics or oxidized metals. Given the delicate nature of certain leathers, suedes and vinyls, all goods containing any such item or items will be cleaned entirely at the Customer’s own risk.
                            </p>',
            ],
            [
                'parent' => 'Company Policies',
                'label' => 'Privacy Policy Content',
                'description' => 'Full privacy policy document customers need to accept beffore proceeding with a booking.',
                'slug' => 'privacy-policy',
                'type' => 'html',
                'value' => '<p>
    <ol>
        <li><b>DEFINITIONS</b><br>
    In these Terms:<br>
    "ACL" means the Australian Consumer Law Schedule of the Competition and Consumer Act;<br>
    "Agreement" means any agreement for the provision of goods and services by the Supplier to the Customer pursuant to a Quote;<br>
    "consumer" is as defined in the ACL and in determining if the Customer is a consumer, the determination is made if Customer is a consumer under the Agreement;<br>
    "Customer" means any person, jointly and severally if more than one, accepting a Quote from the Supplier or in any way using the Services or acquiring goods or services from the Supplier;<br>
    "Intellectual Property Rights" means all present and future rights conferred by statute, common law or equity in or in relation to any copyright, trade marks, designs, patents, circuit layouts, business and domain names, inventions, and other results of intellectual activity in the industrial, commercial, scientific or artistic fields;<br>
    "goods" means any goods, products etc. supplied by the Supplier to the Customer;<br>
    "GST" means the Goods and Services tax as defined in A New Tax System (Goods and Services Tax) Act 1999 as amended;<br>
    "PPSA" means the Personal Property Securities Act 2009 as amended;<br>
    "Quote" means any quote or proposal provided by the Supplier to the Customer, whether verbal or written or any online booking of the Services by the Customer;<br>
    "Services" means the installation services, programming of equipment, consulting and any other services provided by the Supplier to the Customer;<br>
    "Supplier" means JULIA OURETSKI TRADING AS PRAM SPA ABN 15 673 508 634 and any of her employees, contractors and agents; and <br>
    "Terms" means these Terms and Conditions of Supply of Services; and</li>
        <li><b>BASIS OF AGREEMENT</b><br>
    2.1 Unless otherwise agreed by the Supplier in writing, the Terms apply exclusively to every Quote, or provision of goods or Services by the Supplier.<br>
    2.2 By the Customer booking in the time for the supply of the Services, whether verbally or in writing, the Customer accepts these Terms.<br>
    2.3 Please read these Terms carefully before accepting a Quote. By signing the Quote, the Customer agrees to the Quote and the Customer agrees to be bound by these Terms. If the Customer does not agree to all of the Terms, then such Customer may not purchase any goods or services from the Supplier. If these Terms are considered an offer, acceptance is expressly limited to these Terms.<br>
    2.4 An agreement is accepted by the Supplier when the Customer accepts the Quote signed by the Customer.<br>
    2.5 Any change of appointment in regards to the provision of the Services must be received by the Supplier at least 24 hours prior to the booked time or the Customer will be liable for a full fee in relation to the Services.<br>
    2.6 The Supplier has an absolute discretion to refuse to accept any offer or amendment from the Customer or to supply any goods or services including the Services.<br>
    2.7 The Customer must provide the Supplier with its specific requirements in relation to the goods or the Services prior to the Quote being issued.<br>
    2.8 The Supplier may vary or amend these Terms by written notice to the Customer at any time. Any variations or amendments will apply to Quotes and provision of goods and services after the notice date.</li>
        <li><b>PRIOR TO ACCEPTING QUOATION</b><br>
    3.1 Before signing the Quote, the Customer must ensure that the Customer has provided to the Supplier the correct details in relation to the goods to be supplied or services to be provided.<br>
    3.2 If any of the above-mentioned are not in place as specified, the Supplier can, in its absolute'. 'discretion:<br>
    (a) Refuse supply of any goods or Services; or<br>
    (b) Charge the customer for any changes that are required to be made to the goods or Services as a result of the Customer’s non-compliance with clause 3.1 above, </li>
        <li><b>SUPPLY OF GOODS</b><br>
    4.1 All goods are supplied and services provided as per specifications in the Quote or as requested by the Customer and accepted by the Supplier.</li>
        <li><strong>LIMITATION OF LIABILITY</strong><br>
    5.1 Except for where not permitted by law, the Supplier will in no way be liable to any party for any injury, loss or damage arising out of or related to the provision of services. <br>
    5.2 <strong>The Customer acknowledges and agrees that under no circumstances will the Supplier be liable for any direct, indirect, incidental, special or consequential loss or damage to the Customer’s goods (including but not limited to prams and child and infant car seats and capsules), or any discoloration (including sun fading) or damage due to weakness of fabric or defect or any other damage caused by the provision of the Services</strong>.<br>
    5.3 <strong>The Customer acknowledges and agrees that certain types of stains cannot be cleaned in accordance with the recommended cleaning instructions of the manufacturer</strong> and the Supplier may be required to use cleaning methods outside those recommended by the manufacturer, for example using warm or hot water or steam cleaning and the Supplier disclaims any liability for loss of warranty or any other issued that the Customer may incur with the manufacturer as a result of such cleaning methods.<br>
    5.4 <strong>The Supplier cannot guarantee, and hereby specifically excludes, any liability for any colour loss, colour bleeding, shrinkage, damage to weak and tender fabrics or components including aged or brittle plastics or oxidised metals</strong>. Given the delicate nature of certain leathers, suedes and vinyls, all goods containing any such item or items will be cleaned entirely at the Customer’s own risk. Furthermore, where the Customer has opted for its goods to be sealed for longer term storage by the Supplier during the online booking process, the Supplier cannot guarantee that such items will remain permanently sealed and hereby specifically excludes any liability or responsibility for damage caused to such foods in the future due to the conditions or packaging in which the goods were stored including development of moulds, damage caused by moisture or temperature variations or damages caused by pests or vermin. Where the Customer has opted for the Supplier’s tyre inflation service during the online booking process and, upon the performance of this Service, the Supplier finds that one or more of the Customer’s goods’ such as tyres are unable to be properly inflated due to existing damage or fault, then the Supplier may cease efforts (at its sole discretion) to inflate the affected tyres. No refunds will be provided in situations where tyres are unable to hold air pressure due to existing weakness, damage or worn parts. <br>
    5.5 In any event, the Supplier‘s liability with respect to any damage to goods directly caused by the Supplier will be limited to the lesser of the cost of the Supplier repairing the damaged good or that amount being the Supplier’s charge for cleaning that good regardless of its brand or condition at the time of delivery to the Supplier, whichever is the lesser. No claims for damages will be recognised unless the Customer advises the Supplier in writing (email is acceptable) of the same within 24 hours of receiving its goods back from the Supplier.<br>
    5.6 The Customer must check each of its goods for any money, jewellery or other valuables that may be contained in or on them prior to their delivery to or collection by the Supplier. If the Supplier finds any valuables in the Supplier’s goods, the Supplier will make every effort to return them to the Customer but the Supplier cannot be, and expressly excludes any liability or responsibility for, any loss of any such articles that are forwarded to the Supplier.<br>
    5.7 The Customer further acknowledges and agrees that the Service to be provided will depend on the package chosen by the Customer. For example, a basic package does not include the same Service as the premium package and the Supplier disclaims any liability if the Customer chooses a lesser package as the basic package includes a lesser amount of cleaning than any other package including premium package.<br>
    5.7.1 The Customer acknowledges and agrees that Supplier has no liability or responsibility to advice the Customer of any parts or items missing in the Customer'.'s goods brought in for cleaning.<br>
            5.8 Where liability cannot be excluded, any liability incurred by the Supplier is limited to either the re-supply of the Services or the cost of the Services to the Customer.<br>
            5.9 Except as these Terms specifically state, or as contained in any express warranty provided by the Supplier, the agreement for the supply of the Services from the Supplier to the Customer does not include by implication any other term, condition or warranty in respect of the quality, merchantability, acceptability, fitness for purpose, condition, description, assembly, manufacture, design or performance of the goods or services or any contractual remedy for their failure.</li>
        <li><b>PRICING</b><br>
            6.1 Prices quoted for the supply of goods include GST and any other taxes or duties imposed on or in relation to the goods and services.<br>
            6.2 All prices are subject to change without notice.<br>
            6.3 If the Customer requests any variation to the Quote, the Supplier may increase the price to account for the variation. However, this clause does not apply if the Customer decides to change the Quote to a Service which costs less than the original quoted Service and the Customer will be liable for the amount agreed to in the original Quotes.<br>
            6.4 Where there is any change in the costs incurred by the Supplier in relation to goods or the Services, the Supplier may vary its price to take account of any such change, by notifying the Customer.<br>
            6.5 Any delay in the start of the provision of the Services or the supply of the goods caused by the Customer, including but not limited to any delay, default, act or omission on the part of Customer, may change the Price at the absolute discretion of the Supplier to take into account either of any increase in cost to Supplier or changes as a result of any variation in the terms of the Quote.</li>
        <li><b>PAYMENT</b><br>
            7.1 Upon the Customer booking the Services, the Customer accepts the pricing of the Services and these Terms and must pay the full amount for the booked Services. <br>
            7.2 In a situation where the Customer has been charged over the required amount for the Services or the goods or a refund is due to the Customer, the Supplier undertakes to directly refund the money to the Customer’ within 14 days. The Supplier reserves the right to charge extra for any additional work that the Supplier is required to undertake as a result of any incorrect selection or other error made by the Customer during the online booking process. In addition, a re-delivery fee may be charged where the Customer is not home at the prescribed delivery time and did not authorise the Supplier, in the prescribed manner during the online booking process, to leave the Customer’s pram or other item (each a good) unattended at the Customer’s premises.<br>
            7.3 Until payment is made, no goods or Services will be supplied or provided.<br>
            7.4 Unless otherwise agreed in writing, any payments can be made as advised by the Supplier.<br>
            7.5 All payments must be made upon acceptance of the Quote by the Customer and booking online, unless otherwise agreed in writing by the Supplier or in accordance with the terms listed in clause 7.2.<br>
            7.6 The Customer will be provided with details of all payment options available.<br>
            7.7 Payment terms may be revoked or amended at the Supplier’s sole discretion immediately upon giving the Customer written notice.<br>
            7.8 The time for payment is of the essence and all invoices should be paid on or before the due date. </li>
        <li><b>PAYMENT DEFAULT</b><br>
            8.1 If any services or goods are to be paid up front or on the invoice issued, and the Customer defaults in payment by the due date of any amount payable to the Supplier, then all money which would become payable by the Customer to the Supplier at a later date on any account, becomes immediately due and payable without the requirement of any notice to the Customer, and the Supplier may, without prejudice to any of its other accrued or contingent right :<br>
            (a) charge the Customer interest on any sum due at the prevailing rate pursuant to the Penalty Interest Rates Act 1983 (Vic) plus 4 per cent for the period from the due date until the date of payment in full;<br>
            (b) charge the Customer for, and the Customer must indemnify the Supplier from, all costs and expenses (including without limitation all legal costs and expenses) incurred by it resulting from the default or in taking action to enforce compliance with the Terms or to recover any goods;<br>
            (c) cease or suspend supply of any further goods to the Customer; and<br>
            (d) by written notice to the Customer, terminate any uncompleted contract with the Customer.<br>
            8.2 Clauses 8.1(c) and (d) may also be relied upon, at the Supplier’s option, where the Customer is a natural person and becomes bankrupt or enters into any scheme of arrangement or any assignment or composition with or for the benefit of his or her creditors or any class of his or her creditors generally or where the Customer is a corporation and, it enters into any scheme of arrangement or any assignment or composition with or for the benefit of its creditors or any class of its creditors generally, or has a liquidator, administrator, receiver or manager or similar functionary appointed in respect of its assets, or any action is taken for, or with the view to, the liquidation (including provisional liquidation), winding up or dissolution without winding up of the Customer.</li>
        <li><b>PASSING OF PROPERTY – GOODS SOLD</b><br>
            9.1 Until the Supplier receives full payment in cleared funds for all goods (to be) supplied by it to the Customer, as well as all other amounts owing to the Supplier by the Customer:<br>
            (a) title and property in all goods remain vested in the Supplier and do not pass to the Customer; <br>
            (b) title to all goods sold by the Supplier remain vested in the Supplier and do not pass to the Customer until full payment of the funds owed for the goods to the Supplier are paid in full. Until such time, the Customer hereby grants the Supplier a security interest in such goods and agrees that it shall not sell, charge or otherwise dispose of the goods and shall not allow any distress or other form of execution to be executed on the goods; <br>
            (c) the Customer must hold the goods as fiduciary bailee and agent for the Supplier, and must keep the goods separate from its goods and maintain the Supplier’s labelling and packaging; and<br>
            (d) in addition to the rights under the PPSA, until full payment is received by the Supplier for the goods, the Supplier may, without notice to the Customer, enter any premises where it suspects the goods are located and remove them, notwithstanding that they may have been attached to other goods not the property of the Supplier, and for this purpose the Customer irrevocably licences the Supplier to enter such premises and also indemnifies the Supplier from and against all costs, claims, demands or actions by any party arising from such action.</li>
        <li><b>PERSONAL PROPERTY SECURITIES ACT</b><br>
            10.1 Notwithstanding anything to the contrary contained in these Terms, the PPSA applies to these Terms.<br>
            10.2 For the purposes of the PPSA:<br>
            (a) terms used in clause 10 that are defined in the PPSA have the same meaning as in the PPSA;<br>
            (b) these Terms are a security agreement and the Supplier has a Purchase Money Security Interest in all present and future goods supplied by the Supplier to the Customer and the proceeds of the goods;<br>
            (c) The security interest is a continuing interest irrespective of whether there are monies or obligations owing by the Customer at any particular time; and<br>
            (d) the Customer must do whatever is necessary in order to give a valid security interest over the goods which is able to be registered by the Supplier on the Personal Property Securities Register.<br>
            10.3 The security interest arising under this clause 10 attaches to the goods when the goods are collected or dispatched from the Supplier'.'s premises and not at any later time.<br>'.
                    ' 10.4 Where permitted by the PPSA, the Customer waives any rights to receive the notifications, verifications, disclosures or other documentation specified under sections 95, 118, 121(4), 130, 132(3)(d), 132(4), 135 and 157 of the PPSA.<br>
    10.5 To the extent permitted by the PPSA, the Customer agrees that:<br>
    (a) the provisions of Chapter 4 of the PPSA which are for the benefit of the Customer or which place obligations on the Supplier will apply only to the extent that they are mandatory or the Supplier agrees to their application in writing; and<br>
    (b) where the Supplier has rights in addition to those in Chapter 4 of the PPSA, those rights will continue to apply.<br>
    10.6 The Customer must immediately upon the Supplier'.'s request:<br>
            (a) do all things and execute all documents necessary to give effect to the security interest created under this Agreement; and<br>
            (b) procure from any person considered by the Supplier to be relevant to its security position such agreements and waivers (including as equivalent to those above) as the Supplier may at any time require. <br>
            10.7 The Supplier may allocate amounts received from the Customer in any manner the Supplier determines, including in any manner required to preserve any Purchase Money Security Interest it has in goods supplied by the Supplier. </li>
        <li><b>RISK AND INSURANCE</b><br>
            11.1 The risk in the goods supplied provided by the Supplier and all insurance responsibility for theft, damage or otherwise will pass to the Customer immediately on the goods being delivered to the Customer or taken from the Supplier’s premises.<br>
            11.2 The Customer assumes all risk and liability for loss, damage or injury to persons or to property of the Customer, or third parties arising out of the use, installation or possession of any of the goods sold by the Supplier, unless recoverable from the Supplier on the failure of any statutory guarantee under the ACL.</li>
        <li><b>PERFORMANCE OF AGREEMENT</b><br>
            12.1 Any period or date for delivery of goods and services stated by the Supplier is an estimate only and not a contractual commitment.<br>
            12.2 The Supplier will use reasonable endeavours to meet any estimated dates for delivery of the goods and services but will not be liable for any loss or damage suffered by the Customer or any third party for failure to meet any estimated date.<br>
            12.3 The Supplier'.'s delivery or cleaning records will be prima facie proof of delivery of the goods or provision of the Services to the Customer.</li>
        <li><b>DELIVERY</b><br>
    13.1 Subject to clause 13.5, the Supplier will arrange for the delivery of the goods to the Customer, which includes the goods sold by the Supplier or the return of the Customer’s goods to the Customer.<br>
    13.2 The Customer is responsible for all costs associated with delivery, including freight, insurance and other charges arising from the point of dispatch of the goods to the Customer to the point of delivery. <br>
    13.3 The Supplier may make part delivery of goods and the Supplier may invoice the Customer for the goods provided.<br>
    13.4 In the event that the Customer’s goods are unable to be returned to the Customer because the Customer is not contactable or available to take delivery or come and collect its goods as directed by the Supplier within 60 days of the date of the first attempt to contact the Customer, the Supplier reserves the right to dispose of all or any of those goods and shall not be held liable for any loss that the Customer may suffer in such an event. A re-delivery fee may be charged where the Customer was not home at the prescribed delivery time and did not authorise the Supplier to leave its goods unattended at its premises as the Customer had instructed during the online booking process.<br>
    13.5 The Customer indemnifies the Supplier against any loss or damage suffered by the Supplier, its sub-contractors or employees as a result of any delivery, except where the Customer is a consumer and the Supplier has not used due care and skill.<br>
    13.6 Delivery is deemed to have taken place once a confirmation has been entered into the Supplier’s system, or a delivery docket is signed by the Customer. If delivery is attempted and is unable to be completed, the Customer is deemed to have taken delivery of the goods. The Customer is liable for any re-postage charges if the goods are returned to the Supplier payable on demand.<br>
    13.7 The Supplier exercises utmost care in processing the Customer’s goods and to avoid their misplacement or loss. However, there may be instances where the Customer’s goods may get misplaced or lost (although the Supplier has never misplaced or lost a good since it has been in operation). As such, the Supplier requires that the Customer advises the Supplier of any discrepancy within 24 hours of first receiving its cleaned goods so that the Supplier may investigate the matter and make a determination. The Supplier’s liability with respect to any misplaced or lost goods shall not exceed six (6) times the Supplier’s charge for cleaning that good regardless of brand or condition at the time of delivery of the good by the Customer to the Supplier.<br>
    13.8 If agreed that the Customer will collect the' .'goods:<br>
    (a) the Customer must collect the goods on the agreed date; and<br>
    (b) if the Customer does not collect the goods on that date or rescheduled the date at least 24 hours in advance, the Customer is deemed to have taken delivery of the goods and no liability will be borne by the Supplier in relation to the Customer loosing rights to the goods.</li>
        <li><b>REFUNDS</b><br>
    14.1 The Supplier will not accept return of goods, unless the goods are of not merchantable quality.<br>
    14.2 No refunds will be provided for the Services performed unless any other clause of these Terms applies.<br>
    14.3 In the event that the goods are damaged in transit, the Customer must notify the Supplier within 24 hours of receiving the goods and provide the Supplier with photographs of the damage. The Supplier will then provide instructions to the Customer on returning such goods and obtaining a replacement or a refund, at the sole discretion of the Supplier. <br>
    14.4 No refunds will be given when the Customer provided wrong dimensions for any of the goods.<br>
    14.5 If the Customer is not 100% satisfied with the Services provided by the Supplier, the Supplier may, in its absolute discretion, either fully refund the total amount paid by the Customer for the Services or will re-clean the Customer’s goods again at no cost to the Customer. This clause only applies where the Customer advises the Supplier in writing (email is acceptable), including photos of the Customer’s goods, within 24 hours of the Customer receiving its goods, that the Customer is not satisfied with the Services provided by the Supplier.</li>
        <li><b>PRODUCT AND SERVICES WARRANTY</b><br>
    15.1 The Customer acknowledges and agrees that the warranty for all goods purchased from the Supplier will be manufacturer’s warranty only and the Customer will be subject to the terms and conditions of the warranty of the relevant manufacturer of goods.</li>
        <li><b>LIABILITY</b><br>
    16.1 Except as the Terms specifically state, or as contained in any express warranty provided in relation to the goods or the Services, the Terms do not include by implication any other term, condition or warranty in respect of the quality, merchantability, acceptability, fitness for purpose, condition, description, assembly, manufacture, design or performance of the goods or any contractual remedy for their failure.<br>
    16.2 If the Customer is a consumer, nothing in these Terms restricts, limits or modifies the Customer'.'s rights or remedies against the Supplier for failure of a statutory guarantee under the ACL.<br>
            16.3 If the Customer on-supplies the goods to consumer (whether or not they are used up by the Customer in the course of manufacture):<br>
            (a) if the goods are not of a kind ordinarily acquired for personal, domestic or household use or consumption, then the amount specified in section 276A(1) of the ACL is the absolute limit of the Supplier’s liability to the Customer;<br>
            (b) otherwise, payment of any amount required under section 274 of the ACL is the absolute limit of the Supplier’s liability to the Customer;<br>
            howsoever arising under or in connection with the sale, installation, use of, storage or any other dealings with the goods by the Customer or any third party.<br>
            16.4 If clause 16.2 or 16.3 do not apply, then other than as stated in the Terms or any written warranty statement, the Supplier is not liable to the Customer in any way arising under or in connection with the sale, installation, use of, storage or any other dealings with the goods by the Customer or any third party.<br>
            16.5 The Supplier is not liable for any indirect or consequential losses or expenses suffered by the Customer or any third party, howsoever caused, including but not limited to loss of turnover, profits, business or goodwill or any liability to any other party, except to the extent of any liability imposed by the ACL.<br>
            16.6 The Supplier is not liable for any indirect or consequential losses or expenses suffered by the Customer or any third party, howsoever caused, in relation to any perishable or consumable goods.<br>
            16.7 The Customer acknowledges that it has not relied on any advice, recommendation, information or assistance provided by the Supplier in relation to the goods or their use or application and it has not made known, either expressly or by implication, to the Supplier, if applicable, any purpose for which it requires the goods and it has the sole responsibility of satisfying itself that the goods are suitable for the use of the Customer.<br>
            16.8 Nothing in the Terms is to be interpreted as excluding, restricting or modifying or having the effect of excluding, restricting or modifying the application of any State or Federal legislation applicable to the sale of goods or supply of services which cannot be excluded, restricted or modified.</li>
        <li><b>CANCELLATION</b><br>
            17.1 If the Supplier is unable to deliver or provide the goods or the Services, then the Supplier may cancel the Customer'.'s order pursuant to any Quote (even if it has been accepted) by notice to the Customer (written or verbal).<br>
    17.2 No purported cancellation or suspension of an order or any part of it by the Customer is binding on the Supplier once the order has been accepted. </li>
        <li><b>SHORTAGES AND EXCHANGES</b><br>
    18.1 Subject to clause 18.2 and 18.3, the Supplier will not be liable for any shortages, damage or non-compliance with the specifications unless the Customer notifies the Supplier with full details and description within 24 hours of receipt of the Customer’s goods otherwise the Customer is deemed to have accepted the goods.<br>
    18.2 When any shortages, claim for damaged goods or non-compliance with the Agreement specifications is accepted by the Supplier, the Supplier may, at its option, make a payment to the Customer which shall not exceed six (6) times the Supplier’s charge for cleaning that good regardless of brand or condition at the time of delivery of the good by the Customer to the Supplier.<br>
    18.3 If the Customer is a consumer, nothing in this clause 18 limits any remedy available for a failure of the guarantees in sections 56 and 57 of the ACL.</li>
        <li><b>CREDIT INFORMATION AND PRIVACY</b><br>
    19.1 The Customer acknowledges that certain items of information are provided to the Supplier may be disclosed to a credit reporting agency. <br>
    19.2 By engaging the Supplier for the provision of the Services, the Customer authorises the Supplier to obtain consumer and/or commercial information permitted by the Privacy Act from a credit reporting agency and to use such information for the purpose of collecting overdue payments relating to commercial credit owed by the Customer. This authority remains in force until all moneys owed have been repaid.<br>
    19.3 The Supplier may collect, use, store, record and transmit the Customer’s personal information provided by the Customer to the Supplier or any of its contractors, employees or agents. For further details, please refer to the Supplier'.'s Privacy Policy. The Customer’s acceptance of these Terms constitutes approval for the Supplier to deal with the Customer’s personal information.</li>
        <li><b>CUSTOMER OBLIGATIONS AND WARRANTY<br></b>
            20.1 The Customer must provide the Supplier and its employees and contractors with full access to the agreed premises on the day agreed between the parties for the provision of the Services by the Supplier.<br>
            20.2 The Customer acknowledges and agrees that in the event that the Supplier is denied access to the Customer’s premises on the date agreed to by the Customer or the state of the premises prohibits the Supplier’s ability to perform the Services, the Customer will be liable for all costs incurred by the Supplier in having to resupply the Services on a different date, including wasted cost of labour and travel by the Supplier’s employees and contractors. <br>
            20.3 The Customer warrants all the information, including financial information, provided to the Supplier is complete and accurate. The Customer acknowledges that the Supplier will rely on the information when making a decision whether to provide the Services.</li>
        <li><b>FORCE MAJEURE</b><br>
            21.1 The Supplier is not liable in any way howsoever arising under the Terms to the extent that it is prevented from acting by events beyond its reasonable control including, without limitation, industrial disputes, strikes, lockouts, accident, breakdown, import or export restrictions, acts of God, acts or threats of terrorism or war. If an event of force majeure occurs, the Supplier may suspend any orders with the Customer and terminate the Terms by written notice to the Customer.</li>
        <li><b>SAFE CLEAN GUARANTEE</b><br>
            22.1 The Supplier offers a safe cleaning guarantee (Safe Clean Guarantee). The Safe Clean Guarantee means the Supplier will clean the Customer’s goods that it accepts, safely, in mould only. The Supplier uses only non-toxic, eco-friendly cleaning products to clean the surfaces of all goods that regularly come into direct contact with the user of the goods cleaned (e.g. a child). <strong>The exception to this is where the Customer opts for the Supplier’s “Full Mould Treatment” which may require the use of certain chemicals such as bleaches used in diluted quantities</strong>. All such treated goods are fully rinsed following treatment to ensure traces of chemicals are removed as far as is reasonably practicable. In the Supplier’s experience, reliable treatment for moulds (in particular black mould) requires the use of such chemicals in diluted form. However, the Safe Clean Guarantee does not mean that the Supplier can always remove every stain from every good. If the Supplier is of the opinion that application of stain removal to any of the Customer’s goods will be unsafe, or will compromise the Safe Clean Guarantee, all efforts to remove that stain may be terminated at the Supplier’s sole discretion. <br>
            22.2 The Supplier takes no responsibility for the assembly or reassembly of any goods including the assembly or reassembly of any prams, strollers or child restraint seats including, but not limited to, their subcomponents such as wheels, tires and inner tubes, webbings, fabrics, straps, clips, fixings, harnesses or restraint belts and buckles. The Supplier takes no responsibility for the safe assembly, installation and use of any goods (including child restraint seats). The safe assembly, installation and use of any goods (including child restraint seats) is the responsibility of the Customer.<br>
            22.3 This clause only applies to cleaning of mould.</li>
        <li><b>GIFT CERTIFICATES</b><br>
            23.1 Any gift certificate must be used within by the expiry date of the gift certificate.</li>
        <li><b>TITLE, INTELLECTUAL PROPERTY RIGHTS AND COPYRIGHT</b><br>
            24.1 The Customer acknowledges and agrees that:<br>
            (a) the Supplier owns all the Intellectual Property, copyright, and all the contents of any printed or online materials; <br>
            (b) the Customer will not acquire any interest in the Intellectual Property, goods or Services; and<br>
            (c) acknowledges and agrees that all content, graphics, design, goods and Services are protected by copyright, trade mark or other Intellectual Property rights and laws and remains the property of the Supplier or third party suppliers as the case may be.<br>
            24.2 The Customer further acknowledges that the use or duplication of the Intellectual Property in any other way other than as approved and agreed to by the Supplier would constitute a breach of the Supplier’s Intellectual Property rights and would be a fundamental breach of these Terms. However, the Customer may download and print these Terms and the Privacy Policy for your personal non-commercial use.<br>
            24.3 © JULIA OURETSKI TRADING AS PRAM SPA ABN 15 673 508 634. All rights reserved.<br>
            24.4 All trade marks and trade of the Supplier are proprietary to the Supplier and/or its affiliates. Use of these trade marks without the owner'.'s consent will infringe the owner'.'s intellectual property rights. <br>
            24.5 The Supplier reserves the right to refuse to supply the Services or sell any goods to a Customer.</li>
        <li><b>MISCELLANEOUS</b><br>
            25.1 The law of Victoria from time to time governs the Terms. The parties agree to the non-exclusive jurisdiction of the courts of Victoria, the Federal Court of Australia, and of courts entitled to hear appeals from those Courts.<br>
            25.2 The Supplier’s failure to enforce any of these Terms shall not be construed as a waiver of any of the Supplier’s rights.<br>
            25.3 If a clause is unenforceable it must be read down to be enforceable or, if it cannot be read down, the term must be severed from the Terms, without affecting the enforceability of the remaining terms.<br>
            25.4 A notice must be in writing and handed personally or sent by email, facsimile or prepaid mail to the last known address of the addressee. Notices sent by pre-paid post are deemed to be received upon posting. Notices sent by facsimile or email </li>
    </ol>
    </p>',
            ],
            [
                'parent' => 'Email Business Details',
                'label' => 'Turnaround TIme',
                'description' => 'The turnaround time listed in the confirmation email sent to a customer',
                'slug' => 'turnaround-time',
                'type' => 'text',
                'value' => 'Turnaround time is 2-7 business days. Please ask for a complementary stroller if required.',
            ],
            [
                'parent' => 'Email Business Details',
                'label' => 'BSB Number',
                'description' => 'BSB Number listed in the confirmation email sent to a customer',
                'slug' => 'bsb-number',
                'type' => 'text',
                'value' => '083004',
            ],

            [
                'parent' => 'Email Business Details',
                'label' => 'Account Number',
                'description' => 'Account Number listed in the confirmation email sent to a customer',
                'slug' => 'account-number',
                'type' => 'text',
                'value' => '316676701',
            ],

            [
                'parent' => 'Website wide',
                'label' => 'Website Title',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title',
                'type' => 'text',
                'value' => 'Pram Spa',
            ],
            [
                'parent' => 'Website wide',
                'label' => 'Logo',
                'description' => 'Shown in the centre of the home page, and also in the top corner of all administration pages.',
                'slug' => 'logo',
                'type' => 'image',
            ],

            [
                'parent' => 'Website wide',
                'label' => 'Copyright Message',
                'description' => 'Copyright information shown at the bottom of the home page.',
                'slug' => 'copyright-message',
                'type' => 'text',
                'value' => 'Copyright © 2024 Pram Spa. All Rights Reserved.',
            ],
//            [
//                'parent' => 'Contact Us',
//                'label' => 'Location',
//                'description' => 'Location details. Where the main office of Pram Spa is. ',
//                'slug' => 'location',
//                'type' => 'html',
//                'value' => ' <strong><a href="https://pramspa.com.au/contact-us/" target="_blank">CONTACT US</a></strong>
//                <p class="mb-1">
//                    Location: 789 Centre Road, Bentleigh East, VIC 3165.
//                </p>
//                <p class="mb-1">
//                    Email: info@pramspa.com.au
//                </p>
//                <p class="mb-3">
//                    Phone number: +61 424 624 516
//                </p>',
//            ],
            [
                'parent' => 'Contact Us',
                'label' => 'Main Website Link',
                'description' => 'Link to the main website\'s contact us page',
                'slug' => 'main-website-link',
                'type' => 'text',
                'value' => 'https://pramspa.com.au/contact-us/'
            ],
            [
                'parent' => 'Contact Us',
                'label' => 'Location',
                'description' => 'Location details. Where the main office of Pram Spa is.',
                'slug' => 'location',
                'type' => 'text',
                'value' => 'Location: 789 Centre Road, Bentleigh East, VIC 3165.',
            ],

            [
                'parent' => 'Contact Us',
                'label' => 'Email',
                'description' => 'Email details. What email address someone can email to get in contact with us.',
                'slug' => 'email',
                'type' => 'text',
                'value' => 'info@pramspa.com.au',
            ],

            [
                'parent' => 'Contact Us',
                'label' => 'Phone Number',
                'description' => 'Phone number someone can use to get in contact with us.',
                'slug' => 'phone-number',
                'type' => 'text',
                'value' => '+61 424 624 516',
            ],

            ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
