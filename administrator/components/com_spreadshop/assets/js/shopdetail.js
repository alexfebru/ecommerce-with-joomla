jQuery(document).ready(function($){
    checkLocaleSelection();
    jQuery("#jform_platform").change(checkLocaleSelection);

});

function checkLocaleSelection() {
    // Locale value-groups NA & EU
    var valueNA = ['en_US', 'en_CA', 'fr_CA', 'en_AU'];
    var valueEU = ['da_DK','en_EU','en_GB','en_IE','de_DE','de_AT','de_CH','fr_CH','it_CH','es_ES','fi_FI','fr_BE','nl_BE','nl_NL','no_NO','pl_PL','sv_SE'];
    var platformSelection = jQuery("#jform_platform").val();

    switch (platformSelection) {
        case 'EU':
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueEU ) === -1);
            }).hide().prop("selected", false);
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueNA ) === -1);
            }).show();
            break;
        case 'NA':
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueNA ) === -1);
            }).hide().prop("selected", false);
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueEU ) === -1);
            }).show();
            break;
        case '':
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueEU ) === -1);
            }).hide().prop("selected", false);
            jQuery('#jform_locale option').filter(function() {
                return (jQuery.inArray( this.value, valueNA ) === -1);
            }).hide().prop("selected", false);
            break;
    }
}