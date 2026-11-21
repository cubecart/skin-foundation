{*
 * CubeCart v6
 * ========================================
 * CubeCart is a registered trade mark of CubeCart Limited
 * Copyright CubeCart Limited 2026. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:   https://www.cubecart.com
 * Email:  hello@cubecart.com
 * License:  GPL-3.0 https://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * OPTIONAL, new in CubeCart 6.9.0. Cubecart::_pay() draws this page for an order
 * that is paid exactly as it stands: from a payment link the merchant sent, or
 * from Complete Payment on an order that kept no basket (one raised in the admin).
 * Without this file core shows content.gateway.php with the amount due above it.
 *
 * $PAY.state decides what is drawn: 'payable' shows the order, the payment
 * methods and the Pay button; anything else shows $PAY.title and $PAY.message.
 *
 * The form MUST post back to $PAY.action, which carries the link's key. Nothing
 * here is editable: the customer pays the order as the merchant raised it.
 *
 * $SUM, $ITEMS, $TAXES and $DISCOUNT are as content.receipt.php has them, and
 * $GATEWAYS is as content.gateway.php has it (FALSE when no payment method is
 * open to the order). $PAY.amount_due and $gateway.description are HTML.
 *}
{if $PAY.state != 'payable'}
<h2>{$PAY.title}</h2>
<p>{$PAY.message}</p>
<div class="text-center">
   {if !empty($PAY.order_url)}<a href="{$PAY.order_url}" class="button">{$LANG.common.view_details}</a>{/if}
   <a href="{$STORE_URL}" class="button secondary">{$LANG.basket.continue_shopping}</a>
</div>
{else}
<h2>{$LANG.orders.pay_title}</h2>
<p>{$PAY.amount_due}</p>
{if !empty($PAY.attempted)}
<div class="alert-box warning">{$PAY.attempted}</div>
{/if}
<hr>
<h3>{$LANG.basket.order_summary}</h3>
<table class="expand">
   <thead>
      <tr>
         <th>{$LANG.common.product}</th>
         <th class="text-center">{$LANG.catalogue.price_each}</th>
         <th class="text-center">{$LANG.common.quantity}</th>
         <th class="text-right">{$LANG.common.price}</th>
      </tr>
   </thead>
   <tbody>
      {foreach from=$ITEMS item=item}
      <tr>
         <td>
            {$item.name}{if !empty($item.product_code)} ({$item.product_code}){/if}
            {if !empty($item.options)}<br>
            <small>{foreach from=$item.options item=option}{$option}<br>{/foreach}</small>
            {/if}
         </td>
         <td class="text-center">{$item.price}</td>
         <td class="text-center">{$item.quantity}</td>
         <td class="text-right">{$item.price_total}</td>
      </tr>
      {/foreach}
   </tbody>
   <tfoot>
      <tr>
         <td colspan="2"></td>
         <td>{$LANG.basket.total_sub}</td>
         <td class="text-right">{$SUM.subtotal}</td>
      </tr>
      <tr>
         <td colspan="2"></td>
         <td>{if !empty($SUM.ship_method)}{str_replace('_',' ',$SUM.ship_method)}{if !empty($SUM.ship_product)} ({$SUM.ship_product}){/if}{else}{$LANG.basket.shipping}{/if}</td>
         <td class="text-right">{$SUM.shipping}</td>
      </tr>
      {foreach from=$TAXES item=tax}
      <tr>
         <td colspan="2"></td>
         <td>{if $tax.included}{$LANG.common.includes} {/if}{$tax.name}</td>
         <td class="text-right">{$tax.value}</td>
      </tr>
      {/foreach}
      {if $DISCOUNT}
      <tr>
         <td colspan="2"></td>
         <td>{$LANG.basket.total_discount}</td>
         <td class="text-right">{$SUM.discount}</td>
      </tr>
      {/if}
      {if $SUM.show_credit}
      <tr>
         <td colspan="2"></td>
         <td>{$LANG.common.credit}</td>
         <td class="text-right">({$SUM.credit_used})</td>
      </tr>
      {/if}
      <tr>
         <td colspan="2"></td>
         <td><strong>{$LANG.basket.total_grand}</strong></td>
         <td class="text-right"><strong>{$SUM.total}</strong></td>
      </tr>
   </tfoot>
</table>
{if !empty($SUM.note_to_customer)}
<blockquote>{$SUM.note_to_customer}</blockquote>
{/if}
<hr>
<h3>{$LANG.basket.customer_info}</h3>
<div class="row">
   <div class="small-6 columns">
      <strong>{$LANG.address.billing_address}</strong><br>
      {$SUM.first_name|capitalize} {$SUM.last_name|capitalize}<br>
      {if $SUM.company_name}{$SUM.company_name}<br>{/if}
      {$SUM.line1|capitalize}<br>
      {if $SUM.line2}{$SUM.line2|capitalize}<br>{/if}
      {$SUM.town|upper}<br>
      {if !empty($SUM.state)}{$SUM.state|upper}, {/if}{$SUM.postcode}{if $CONFIG['store_country_name']!==$SUM['country']}<br>
      {$SUM.country}{/if}
   </div>
   <div class="small-6 columns">
      {if !empty($SUM.line1_d)}
      <strong>{$LANG.address.delivery_address}</strong><br>
      {$SUM.first_name_d|capitalize} {$SUM.last_name_d|capitalize}<br>
      {if $SUM.company_name_d}{$SUM.company_name_d}<br>{/if}
      {$SUM.line1_d|capitalize}<br>
      {if $SUM.line2_d}{$SUM.line2_d|capitalize}<br>{/if}
      {$SUM.town_d|upper}<br>
      {if !empty($SUM.state_d)}{$SUM.state_d|upper}, {/if}{$SUM.postcode_d}{if $CONFIG['store_country_name']!==$SUM['country_d']}<br>
      {$SUM.country_d}{/if}
      {/if}
   </div>
</div>
<hr>
<form id="pay-order" action="{$PAY.action}" method="post">
   {if $GATEWAYS}
   {if count($GATEWAYS) > 1}
   <h3>{$LANG.gateway.select}</h3>
   <ul class="no-bullet">
      {foreach from=$GATEWAYS item=gateway}
      <li>
         <input name="gateway" type="radio" value="{$gateway.folder}" id="pay_{$gateway.folder}" required {$gateway.checked}>
         {if !empty($gateway.help)}
         <a href="{$gateway.help}" class="info" title="{$LANG.common.information}"><svg class="icon"><use xlink:href="#icon-info-circle"></use></svg></a>
         {/if}
         <label for="pay_{$gateway.folder}">{$gateway.description}</label>
      </li>
      {/foreach}
   </ul>
   {else}
   {* One payment method: no choice to offer, but core still wants its name. *}
   {foreach from=$GATEWAYS item=gateway}
   <input type="hidden" name="gateway" value="{$gateway.folder}">
   {/foreach}
   {/if}
   <div class="text-center"><input type="submit" value="{$LANG.checkout.pay_now}" class="button success"></div>
   {else}
   <p>{$LANG.gateway.none_defined}</p>
   {/if}
</form>
{/if}
