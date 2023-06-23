<?php

/**
* Elevator API access class
* How much do we hate curl?
* But I don't know if the target moodle environment has modern libraries, so this seems like a safe bet.
*/
class elevatorAPI
{

    private $userId = null;
    private $apiKey = null;
    private $baseURL = null;
    public $fileTypes = null;

    function __construct($elevatorURL, $apiKey, $apiSecret, $userId=null)
    {
        $this->baseURL = $elevatorURL;
        $this->userId = $userId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getLoginURL($callback) {
        $now = time();
        return $this->baseURL . "login/loginAndRedirect/" . $this->apiKey . "/" . $now . "/" . sha1($now . $this->apiSecret) . "/?" . $callback;
    }

    public function getManageURL() {
        return $this->baseURL . "login/editUser/" . $this->userId;
    }


    /**
     * isCurrentUserLogged in allows us to check if the user's session is currently cached on elevator.
     * This is because elevator is currently reliant entirely on shib sessions for getting things like course enrollment data.
     * If this becomes a big issue, we may want to move to using ldap on the elevator side for that, but I'm hoping to avoid that
     * dependency for now.
     */
    function isCurrentUserLoggedIn($userId) {
        $request = "hello";
        return $this->execute($request, null, $userId);
    }

    function getAssetsFromDrawer($drawerId, $pageNumber=0) {
        $request = "api_drawers/getContentsOfDrawer/" . $drawerId . "/" . ($pageNumber-1) . "/" . $this->fileTypes;
        $assetList = array();
        $result = $this->execute($request);
        if ($result) {
            error_log($result);
            $assetList = json_decode($result, true);
        }

        return $assetList;
    }

    function getAssetsFromCollection($collectionId, $pageNumber=0) {
        $request = "collections/getContentsOfCollection/" . $collectionId . "/" . ($pageNumber-1) . "/" . $this->fileTypes;
        $assetList = array();
        $result = $this->execute($request);
        if ($result) {
            $assetList = json_decode($result, true);
        }

        return $assetList;
    }

    /**
     * In Elevator, a single asset may contain many files.  Moodle doesn't have a great way to display that, so instead
     * in those cases we display the "parent" asset as a folder and place all the files inside it.
     */
    function getAssetChildren($objectId) {
        $request = "asset/getAssetChildren/" . $objectId . "/" . $this->fileTypes;
        $assetList = array();
        $result = $this->execute($request);
        if ($result) {
            $assetList = json_decode($result, true);
        }

        return $assetList;
    }

    function getEmbedContent($objectId, $instance, $excerpt=null) {
        if ($excerpt) {
            $request = "asset/getExcerptLink/" . $excerpt . "/" . $instance;
        }
        else {
            $request = "asset/getEmbedLink/" . $objectId . "/" . $instance;
        }

        $assetLink = "";

        $result = $this->execute($request);
        if ($result) {
            $assetLink = $result;
        }

        return $assetLink;

    }


    function search($searchTerm, $pageNumber = 0) {

        $request = "search/performSearch/";

        $postArray['searchTerm'] = $searchTerm;
        $postArray['pageNumber'] = ($pageNumber - 1); // we keep moodle 1 indexed and fix here

        $assetList = array();

        $result = $this->execute($request, $postArray);
        if ($result) {
            $assetList = json_decode($result, true);
        }

        return $assetList;

    }

    function assetLookup($assetId) {
        $request = "asset/assetLookup/" . $assetId;

        $assetInfo = array();

        $result = $this->execute($request);
        if ($result) {
            $assetInfo = json_decode($result, true);
        }

        return $assetInfo;

    }

    function assetPreview($assetId) {
        $request = "asset/assetPreview/" . $assetId;

        $assetInfo = array();

        $result = $this->execute($request);
        if ($result) {
            $assetInfo = json_decode($result, true);
        }

        return $assetInfo;

    }

    function fileLookup($assetId) {
        $request = "asset/fileLookup/" . $assetId;

        $assetInfo = array();

        $result = $this->execute($request);
        if ($result) {
            $assetInfo = json_decode($result, true);
        }

        return $assetInfo;

    }


    function getDrawers() {
        $request = "api_drawers/listDrawers";
        $drawerList = array();
        $result = $this->execute($request);
        if ($result) {
            $drawerList = json_decode($result, true);
        }

        return $drawerList;
    }

    function getCollections() {
        $request = "collections/listCollections";
        $collectionList = array();
        $result = $this->execute($request);
        if ($result) {
            $collectionList = json_decode($result, true);
        }

        return $collectionList;

    }

    function importAsset($assetBlock, $collectionId, $templateId) {

        $post = [];
        $post['collectionId'] = $collectionId;
        $post['templateId'] = $templateId;
        $post['assets'] = json_encode($assetBlock);

        $request = "import/importAssets/";
        $result = $this->execute($request, $post);
        if ($result) {
            $assetList = json_decode($result, true);
            return $assetList;
        }
    }


    private function execute($targetURL=null, $postArray=null, $userId=null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseURL . $targetURL);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        if (!$userId) {
            $userId = $this->userId;
        }
        if(!$targetURL) {
            return false;
        }

        $now = time();
        $header[] = "Authorization-User: " . $userId;
        $header[] = "Authorization-Key: " . $this->apiKey;
        $header[] = "Authorization-Timestamp: " . $now;
        $header[] = "Authorization-Hash: " . sha1($now . $this->apiSecret);

        if ($postArray) {
            curl_setopt($ch,CURLOPT_POST, count($postArray));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postArray);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        try {
            $data = curl_exec($ch);
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($response == 200) {
                return $data;
            }
            else {
                return false;
            }
        }
        catch (Exception $ex) {
            // echo $ex;
            return false;
        }

    }

}
