tinyMCE.init({
// General options
    mode: "exact",
    theme: "advanced",
    plugins: "smimage,pagebreak,style,table,advimage,advlink,preview,media,print,contextmenu,paste,fullscreen",
    language: "en",
    relative_urls: false,
    remove_script_host: true,
    convert_urls: true,
    verify_html: false,
    width: 950,
// Theme options
    theme_advanced_buttons1: "code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|, bullist,numlist,|,link,unlink,anchor,image",
    theme_advanced_buttons2: "tablecontrols,|,removeformat,visualaid,|,sub,sup,|,media,|,styleprops,|,smimage,|, fullscreen",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,
// Example content CSS (should be your site CSS)
//content_css : "/css/styles.css",

    elements: 'tiny_mce_en, tiny_mce_ru, tiny_mce_ua, tiny_mce_annotation, product_description_en, product_description_ru, product_description_ua'
});
