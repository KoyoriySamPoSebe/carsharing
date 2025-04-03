# OpenAPI\Client\RentApi

All URIs are relative to http://localhost/api, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**rentChangeStatus()**](RentApi.md#rentChangeStatus) | **PATCH** /v1/rent/change-status |  |
| [**rentHistory()**](RentApi.md#rentHistory) | **GET** /v1/rent/history |  |
| [**rentStart()**](RentApi.md#rentStart) | **POST** /v1/rent/create |  |


## `rentChangeStatus()`

```php
rentChangeStatus($rent_change_status_request): \OpenAPI\Client\Model\Rent
```



Change the status of a rent

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$rent_change_status_request = new \OpenAPI\Client\Model\RentChangeStatusRequest(); // \OpenAPI\Client\Model\RentChangeStatusRequest

try {
    $result = $apiInstance->rentChangeStatus($rent_change_status_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RentApi->rentChangeStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **rent_change_status_request** | [**\OpenAPI\Client\Model\RentChangeStatusRequest**](../Model/RentChangeStatusRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Rent**](../Model/Rent.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `rentHistory()`

```php
rentHistory($driver_id, $status, $limit, $offset): \OpenAPI\Client\Model\RentList
```



Get rent history

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$driver_id = 56; // int | Driver ID
$status = new \OpenAPI\Client\Model\RentStatus(); // RentStatus | Rent status
$limit = 56; // int
$offset = 56; // int

try {
    $result = $apiInstance->rentHistory($driver_id, $status, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RentApi->rentHistory: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **driver_id** | **int**| Driver ID | |
| **status** | [**RentStatus**](../Model/.md)| Rent status | [optional] |
| **limit** | **int**|  | [optional] |
| **offset** | **int**|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\RentList**](../Model/RentList.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `rentStart()`

```php
rentStart($rent_start_request): \OpenAPI\Client\Model\Rent
```



Start a rent

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$rent_start_request = new \OpenAPI\Client\Model\RentStartRequest(); // \OpenAPI\Client\Model\RentStartRequest

try {
    $result = $apiInstance->rentStart($rent_start_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RentApi->rentStart: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **rent_start_request** | [**\OpenAPI\Client\Model\RentStartRequest**](../Model/RentStartRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Rent**](../Model/Rent.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
