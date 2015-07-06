<?php
namespace ColissimoApi;

use stdClass;
use DOMDocument;

/**
 * Class Colissimo
 */
class ColissimoApi {
    /**
     * @var $id
     */
    private $id;

    /**
     * class constructor
     */
    public function __construct()
    {
        // if there is something wrong in the url, stop everything
        if (!isset($_GET['id']) || $_GET['id'] == null) {
            echo 'Please fill a Colissimo id in your url.';
            die();
        }

        // get the colissimo id from the url
        $this->id = $_GET['id'];
    }

    /**
     * run the colissimo api
     */
    public function run()
    {
        $id = $this->id;
        $data = $this->getPage($id);
        $filePath = $this->storeTable($data);
        $table = $this->parse($filePath);
        $object = $this->tableArrayToObject($table, $id, $data);

        echo json_encode($object);
    }

    /**
     * get the colissimo.fr page content for an $id
     *
     * @param $id
     * @return mixed
     */
    private function getPage($id)
    {
        $url = "http://www.colissimo.fr/portail_colissimo/suivre.do?colispart=$id";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);

        // if there is no response form colissimo.fr, stop everything
        if ($data == null) {
            echo 'The colissimo.fr website is temporarily down. Please try again';
            die();
        }

        // if the id is more than 90 days old, stop everything
        if ($this->contains($data, 'Num&eacute;ro de suivi datant de plus de 90 jour')) {
            echo 'The colissimo id is more than 90 days old. Please fill a valid Colissimo id in your url.';
            die();
        }
        return $data;
    }

    /**
     * create a temp file with an html table from colissimo.fr
     *
     * @param $data
     * @return string|void
     */
    private function storeTable($data)
    {
        $table = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title></title></head><body><table>' . $this->get_string_between($data, '<table class="dataArray" summary="Suivi de votre colis" width="100%">', '</table>') . '</table></body></html>';
        //$table = mb_convert_encoding($table, 'UTF-8', 'OLD-ENCODING');
        $table = utf8_encode($table);
        //var_dump($table); die;
        $unique_id = uniqid();
        $filePath = 'temp/' . $unique_id . '.html';
        $file = file_put_contents($filePath, $table);

        // if $file is under 600, there is something wrong, stop everything
        if ($file < 600) {
            echo 'Please fill a valid Colissimo id in your url.';
            die();
        }

        return $filePath;
    }

    /**
     * parse html table in the created file $filePath to a multidimensional array
     *
     * @source http://stackoverflow.com/a/10754009/2746369
     * @param $filePath
     * @return array
     */
    private function parse($filePath)
    {
		$content = file_get_contents($filePath);
        //var_dump($content);
        //die();
        $dom = new DOMDocument();
        @$html = $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
        $rows = $tables->item(0)->getElementsByTagName('tr');
        $cols = $rows->item(0)->getElementsByTagName('th');
        $row_headers = null;
        foreach ($cols as $node) {
            $row_headers[] = $node->nodeValue;
        }
        $table = array();
        $rows = $tables->item(0)->getElementsByTagName('tr');
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            $row = array();
            $i=0;
            foreach ($cols as $node) {
                if ($row_headers == null) {
                    $row[] = $node->nodeValue;
                } else {
                    $row[$row_headers[$i]] = $node->nodeValue;
                }
                $i++;
            }
            $table[] = $row;
        }

        return $table;
    }

    /**
     * create an object from the parsed html table array
     *
     * @param $table
     * @param $id
     * @param $data
     * @return stdClass
     */
    private function tableArrayToObject($table, $id, $data)
    {
        $object = new stdClass();
        $object->id          = $id;
        $object->destination = trim($this->get_string_between($data, '<br/>&nbsp;&agrave; destination de :&nbsp;', '</h4>'));
        for ($i = 0; $i < count($table) - 1; $i++) {
            $object->{$i} = new stdClass();
            $object->{$i}->date     = trim($table[$i + 1][0]);
            $object->{$i}->label    = trim($table[$i + 1][1]);
            $object->{$i}->location = trim($table[$i + 1][2]);
        }

        return $object;
    }

    /**
     * Given a string $haystack, search if it contains the string $needle and return
     * true or false. Return false if $haystack or $needle is empty.
     *
     * @source https://gist.github.com/hedii/d96465fc999116e038f7
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function contains($haystack, $needle)
    {
        if (!empty($haystack) && !empty($needle)) {
            if (strpos($haystack, $needle) !== false) {
                // $needle was found in $haystack, return true
                return true;
            }
            return false;
        }

        return false;
    }

    /**
     * Given a string $haystack, remove everything before $delimiter1 ($delimiter1
     * including), and remove everything after $delimiter2 ($delimiter2 including).
     * Return the string between $delimiter1 and $delimiter2 or return false if
     * $delimiter1 or $delimiter2 is not found in $haystack.  Return false if
     * $haystack or $delimiter1 or $delimiter2 is empty. Return false if
     * $hasytack does not contains $delimiter1 and $delimiter2.
     *
     * @source https://gist.github.com/hedii/d96465fc999116e038f7
     * @param $haystack
     * @param $delimiter1
     * @param $delimiter2
     * @return bool
     */
    private function get_string_between($haystack, $delimiter1, $delimiter2)
    {
        if (!empty($haystack) && !empty($delimiter1) && !empty($delimiter2)) {
            if (strpos($haystack, $delimiter1) !== false && strpos($haystack, $delimiter2) !== false) {
                // separate $haystack in two strings and put each string in an array
                $pre_filter = explode($delimiter1, $haystack);
                if (isset($pre_filter[1])) {
                    // remove everything after the $delimiter2 in the second line of the
                    // $pre_filter[] array
                    $post_filter = explode($delimiter2, $pre_filter[1]);
                    if (isset($post_filter[0])) {
                        // return the string between $delimiter1 and $delimiter2
                        return $post_filter[0];
                    }
                    return false;
                }
                return false;
            }
            return false;
        }

        return false;
    }
}