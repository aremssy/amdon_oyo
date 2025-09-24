<?php
class SuiteCRMClient
{
    private $apiUrl;
    private $username;
    private $password;
    private $sessionId;

    // Constructor sets API URL and credentials
    public function __construct()
    {
        $this->apiUrl = 'https://datastore.oncloud.com.ng/service/v4_1/rest.php';
        $this->username = 'Admin';
        $this->password = 'Pa22w0rd';
        $this->sessionId = null;
    }

    // Login to SuiteCRM API to obtain session ID (md5 hashed password)
    public function login(): bool
    {
        $userAuth = [
            'user_name' => $this->username,
            'password' => md5($this->password),
            'version' => '1.1'
        ];

        $params = [
            'user_auth' => $userAuth,
            'application_name' => 'PHP SuiteCRM Client'
        ];

        $response = $this->callMethod('login', $params);

        if (isset($response['id']) && !empty($response['id'])) {
            $this->sessionId = $response['id'];
            return true;
        }

        return false;
    }

    // Make a generic REST API call with method name and parameters
    public function callMethod(string $method, array $params): array
    {
        $postFields = [
            'method' => $method,
            'input_type' => 'JSON',
            'response_type' => 'JSON',
            'rest_data' => json_encode($params)
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }
        $decoded = json_decode($result, true);
        if (!$decoded) {
            throw new Exception("Failed to decode JSON response.");
        }

        return $decoded;
    }
// New method to search records with a query filter
    public function searchRecords(
        string $moduleName,
        string $query = '',
        array $selectFields = [],
        string $orderBy = '',
        int $offset = 0,
        int $maxResults = 20,
        bool $includeDeleted = false
    ): array {
        if (!$this->sessionId) {
            if (!$this->login()) {
                throw new Exception("SuiteCRM API login failed.");
            }
        }

        $params = [
            'session' => $this->sessionId,
            'module_name' => $moduleName,
            'query' => $query,
            'order_by' => $orderBy,
            'offset' => $offset,
            'select_fields' => $selectFields,
            'max_results' => $maxResults,
            'deleted' => $includeDeleted ? 1 : 0,
        ];

        $response = $this->callMethod('get_entry_list', $params);

        // Return the list of entries or empty array if none found
        return $response['entry_list'] ?? [];
    }
    public function getRecordById(string $moduleName, string $recordId, array $selectFields = []): ?array
{
    if (!$this->sessionId) {
        if (!$this->login()) {
            throw new Exception("SuiteCRM API login failed.");
        }
    }

    $params = [
        'session' => $this->sessionId,
        'module_name' => $moduleName,
        'id' => $recordId,
        'select_fields' => $selectFields,
        'link_name_to_fields_array' => [],
        'max_results' => 1,
        'deleted' => 0,
    ];

    $response = $this->callMethod('get_entry', $params);

    if (!empty($response['entry_list'][0]['name_value_list'])) {
        return $response['entry_list'][0]['name_value_list'];
    }

    return null;
}
    // Helper: call set_entry to create or update a record
    public function setEntry(string $moduleName, array $nameValueList, ?string $recordId = null): ?string
    {
        if (!$this->sessionId) {
            if (!$this->login()) {
                throw new Exception("SuiteCRM API login failed.");
            }
        }
        $params = [
            'session' => $this->sessionId,
            'module_name' => $moduleName,
            'name_value_list' => $nameValueList
        ];
        if ($recordId) {
            // Update existing record
            // Ensure id is in name_value_list
            $params['name_value_list'][] = ['name' => 'id', 'value' => $recordId];
        }

        $response = $this->callMethod('set_entry', $params);

        return $response['id'] ?? null;
    }

    // You can add more SuiteCRM API helper methods here as needed

    // Get current session ID
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }
}
