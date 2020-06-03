<?PHP
class LanguageLoader
{
    function initialize()
    {
        $ci =& get_instance();

        $siteLang = $ci->session->userdata('site_lang');
        if (!empty($siteLang)) {
            $ci->language->load('', $siteLang);
        } else {
            $ci->language->load('', 'english');
        }

    }
}