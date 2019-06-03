<{include file='db:xliaise_header.tpl'}>

<{if $forms_breadcrumb}>
    <div class="breadcrumbs">
        <a href="<{$xoops_url}>"><{$smarty.const._LIAISE_HOMEPAGE}></a>
        <{$smarty.const._LIAISE_BRDCRMB_SEP}>
        <a href="<{$smarty.const.LIAISE_URL}>"><{$smarty.const._LIAISE_ROOT}></a>
        <{$smarty.const._LIAISE_BRDCRMB_SEP}>
        <{$xoops_pagetitle}>
    </div>
    <div class="clear"></div>
<{/if}>

<p></p>

<div class="liaiseMain">

    <h2><{$form_output.title}></h2>

    <{* ticket and captcha error *}>
    <{if $form_error != ""}>
        <div class="errorMsg"><{$form_error}></div>
    <{/if}>
    <{if $form_is_hidden != ""}><p><{$form_is_hidden}></p><{/if}>

    <{if $form_intro != ""}><p><{$form_intro|@html_entity_decode}></p><{/if}>
    <div class="clear"></div>

    <{$form_output.javascript}>
    <form name="<{$form_output.name}>" id="<{$form_output.name}>" action="<{$form_output.action}>"
          method="<{$form_output.method}>" class="liaise" <{$form_output.extra}>>
        <table class="outer">
            <{foreach item=element from=$form_output.elements}>
                <{if $element.hidden != true}>
                    <tr>
                        <{if $element.caption|strstr:"[BREAK]"}>
                            <td class="xliaise_break" colspan="2">
                                <{$element.caption|replace:"[BREAK]":""}>
                            </td>
                        <{else}>
                            <th><{if $element.caption == "" }>&nbsp;<{/if}><{if $element.required == 1}><{$form_req_prefix}><{/if}>
                                <{$element.caption}>
                                <{if $element.required == 1}><span class="required"><{$form_req_suffix}></span><{/if}>
                            </th>
                            <td class="<{cycle values="even,odd"}>"><{$element.body}></td>
                        <{/if}>
                    </tr>
                <{/if}>
            <{/foreach}>
        </table>
        <{foreach item=element from=$form_output.elements}>
            <{if $element.hidden == true}>
                <{$element.body}>
            <{/if}>
        <{/foreach}>
        <{if $form_text_global != ""}>
            <div><{$form_text_global|@html_entity_decode}></div><{/if}>
        <{securityToken}>
    </form>
</div>
