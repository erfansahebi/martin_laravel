<?php

namespace App\Enums;

enum ResponseStatusCodeEnum: int
{

	/**
	 *  Important Note From https://en.wikipedia.org/wiki/List_of_HTTP_status_codes :
	 *
	 *  For a PUT request: HTTP 200, HTTP 204 should imply "resource updated successfully".
	 *  HTTP 201 if the PUT request created a new resource.
	 *  For a DELETE request: HTTP 200 or HTTP 204 should imply "resource deleted successfully".
	 *  HTTP 202 can also be returned by either operation and would imply that the instruction was accepted by the server,
	 *  but not fully applied yet. It's possible that the operation fails later,
	 *  so the client shouldn't fully assume that it was success.
	 *  A client that receives a status code it doesn't recognize, but it's starting with 2 should treat it as a 200 OK.
	 *
	 *  PUT
	 *  If an existing resource is modified,
	 *  either the 200 (OK) or 204 (No Content) response codes SHOULD be sent to indicate successful completion of the request.
	 *
	 *  DELETE
	 *  A successful response SHOULD be 200 (OK) if the response includes an entity describing the status,
	 *  202 (Accepted) if the action has not yet been enacted,
	 *  or 204 (No Content) if the action has been enacted but the response does not include an entity.
	 */


	//  ========================== 1xx Information Response ==========================


	/**
	 *  The server has received the request headers and the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request).
	 *  Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient.
	 *  To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body.
	 *  If the client receives an error code such as 403 (Forbidden) or 405 (Method Not Allowed) then it should not send the request's body.
	 *  The response 417 Expectation Failed indicates that the request should be repeated without the Expect header as it indicates that the server does not support expectations (this is the case, for example, of HTTP/1.0 servers).
	 */
	case Continue = 100;

	/**
	 *  The requester has asked the server to switch protocols and the server has agreed to do so.
	 */
	case SwitchingProtocols = 101;

	/**
	 *  A WebDAV request may contain many sub-requests involving file operations, requiring a long time to complete the request.
	 *  This code indicates that the server has received and is processing the request, but no response is available yet.
	 *  This prevents the client from timing out and assuming the request was lost.
	 *  The status code is deprecated.
	 */
	case Processing = 102;

	/**
	 *  Used to return some response headers before final HTTP message.
	 */
	case EarlyHints = 103;


	//  ========================== 2xx Success ==========================


	/**
	 *  Standard response for successful HTTP requests.
	 *  The actual response will depend on the request method used.
	 *  In a GET request, the response will contain an entity corresponding to the requested resource.
	 *  In a POST request, the response will contain an entity describing or containing the result of the action.
	 */
	case OK = 200;

	/**
	 *  The request has been fulfilled, resulting in the creation of a new resource.
	 */
	case Created = 201;

	/**
	 *  The request has been accepted for processing,
	 *  but the processing has not been completed.
	 *  The request might or might not be eventually acted upon,
	 *  and may be disallowed when processing occurs.
	 */
	case Accepted = 202;

	/**
	 *  The server is a transforming proxy (e.g. a Web accelerator) that received a 200 OK from its origin,
	 *  but is returning a modified version of the origin's response.
	 */
	case NonAuthoritativeInformation = 203;

	/**
	 *  The server successfully processed the request,
	 *  and is not returning any content.
	 */
	case NoContent = 204;

	/**
	 *  The server successfully processed the request,
	 *  asks that the requester reset its document view, and is not returning any content.
	 */
	case ResetContent = 205;

	/**
	 *  The server is delivering only part of the resource (byte serving) due to a range header sent by the client.
	 *  The range header is used by HTTP clients to enable resuming of interrupted downloads,
	 *  or split a download into multiple simultaneous streams.
	 */
	case PartialContent = 206;

	/**
	 *  The message body that follows is by default an XML message and can contain a number of separate response codes,
	 *  depending on how many sub-requests were made.
	 */
	case MultiStatus = 207;

	/**
	 *  The members of a DAV binding have already been enumerated in a preceding part of the (multi-status) response,
	 *  and are not being included again.
	 */
	case AlreadyReported = 208;

	/**
	 *  The server has fulfilled a request for the resource,
	 *  and the response is a representation of the result of one or more instance-manipulations applied to the current instance.
	 */
	case IMUsed = 226;


	//  ========================== 3xx Redirection ==========================


	/**
	 *  Indicates multiple options for the resource from which the client may choose (via agent-driven content negotiation).
	 *  For example, this code could be used to present multiple video format options, to list files with different filename extensions,
	 *  or to suggest word-sense disambiguation.
	 */
	case MultipleChoices = 300;

	/**
	 *  This and all future requests should be directed to the given URI.
	 */
	case MovedPermanently = 301;

	/**
	 *  Tells the client to look at (browse to) another URL.
	 *  The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect with the same method (the original describing phrase was "Moved Temporarily"),
	 *  but popular browsers implemented 302 redirects by changing the method to GET.
	 *  Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours.
	 */
	case Found = 302;

	/**
	 *  The response to the request can be found under another URI using the GET method.
	 *  When received in response to a POST (or PUT/DELETE),
	 *  the client should presume that the server has received the data and should issue a new GET request to the given URI.
	 */
	case SeeOther = 303;

	/**
	 *  Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match.
	 *  In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy.
	 */
	case NotModified = 304;

	/**
	 *  The requested resource is available only through a proxy,
	 *  the address for which is provided in the response.
	 *  For security reasons many HTTP clients (such as Mozilla Firefox and Internet Explorer) do not obey this status code.
	 */
	case UseProxy = 305;

	/**
	 *  No longer used. Originally meant `Subsequent requests should use the specified proxy.`
	 */
	case SwitchProxy = 306;

	/**
	 *  In this case, the request should be repeated with another URI;
	 *  however, future requests should still use the original URI.
	 *  In contrast to how 302 was historically implemented,
	 *  the request method is not allowed to be changed when reissuing the original request.
	 *  For example, a POST request should be repeated using another POST request.
	 */
	case TemporaryRedirect = 307;

	/**
	 *  This and all future requests should be directed to the given URI.
	 *  308 parallel the behaviour of 301, but does not allow the HTTP method to change.
	 *  So, for example, submitting a form to a permanently redirected resource may continue smoothly.
	 */
	case PermanentRedirect = 308;


	//  ========================== 4xx Client Errors ==========================


	/**
	 *  The server cannot or will not process the request due to an apparent client error
	 *  (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).
	 */
	case BadRequest = 400;

	/**
	 *  Similar to 403 Forbidden,
	 *  but specifically for use when authentication is required and has failed or has not yet been provided.
	 *  The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource.
	 *  See Basic access authentication and Digest access authentication.
	 *  401 semantically means "unauthorised",
	 *  the user does not have valid authentication credentials for the target resource.
	 *  Some sites incorrectly issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.
	 */
	case Unauthorized = 401;

	/**
	 *  Reserved for future use.
	 *  The original intention was that this code might be used as part of some form of digital cash or micro_payment scheme,
	 *  as proposed, for example, by GNU Taler, but that has not yet happened, and this code is not widely used.
	 *  Google Developers API uses this status if a particular developer has exceeded the daily limit on requests.
	 *  Sipgate uses this code if an account does not have sufficient funds to start a call.
	 *  Shopify uses this code when the store has not paid their fees and is temporarily disabled.
	 *  Stripe uses this code for failed payments where parameters were correct,
	 *  for example blocked fraudulent payments.
	 */
	case PaymentRequired = 402;

	/**
	 *  The request contained valid data and was understood by the server, but the server is refusing action.
	 *  This may be due to the user not having the necessary permissions for a resource or needing an account of some sort,
	 *  or attempting a prohibited action (e.g. creating a duplicate record where only one is allowed).
	 *  This code is also typically used if the request provided authentication by answering the WWW-Authenticate header field challenge,
	 *  but the server did not accept that authentication.
	 *  The request should not be repeated.
	 */
	case Forbidden = 403;

	/**
	 *  The requested resource could not be found but may be available in the future.
	 *  Subsequent requests by the client are permissible.
	 */
	case NotFound = 404;

	/**
	 *  A request method is not supported for the requested resource;
	 *  for example, a GET request on a form that requires data to be presented via POST,
	 *  or a PUT request on a read-only resource.
	 */
	case MethodNotAllowed = 405;

	/**
	 *  The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request.
	 *  See Content negotiation.
	 */
	case NotAcceptable = 406;

	/**
	 *  The client must first authenticate itself with the proxy.
	 */
	case ProxyAuthenticationRequired = 407;

	/**
	 *  The server timed out waiting for the request.
	 *  According to HTTP specifications:
	 *  "The client did not produce a request within the time that the server was prepared to wait.
	 *  The client MAY repeat the request without modifications at any later time."
	 */
	case RequestTimeout = 408;

	/**
	 *  Indicates that the request could not be processed because of conflict in the current state of the resource,
	 *  such as an edit conflict between multiple simultaneous updates.
	 */
	case Conflict = 409;

	/**
	 *  The request entity has a media type which the server or resource does not support.
	 *  For example, the client uploads an image as image/svg+xml,
	 *  but the server requires that images use a different format.
	 */
	case UnsupportedMediaType = 415;

	/**
	 *  The user has sent too many requests in a given amount of time.
	 *  Intended for use with rate-limiting schemes.
	 */
	case TooManyRequests = 429;


	//  ========================== 5xx Server Errors ==========================


	/**
	 *  A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
	 */
	case InternalServerError = 500;


	/**
	 *  The server either does not recognize the request method,
	 *  or it lacks the ability to fulfil the request.
	 *  Usually this implies future availability (e.g., a new feature of a web-service API).
	 */
	case NotImplemented = 501;

	/**
	 *  The server was acting as a gateway or proxy and received an invalid response from the upstream server.
	 */
	case BadGateway = 502;

	/**
	 *  The server cannot handle the request (because it is overloaded or down for maintenance).
	 *  Generally, this is a temporary state.
	 */
	case ServiceUnavailable = 503;

	/**
	 *  The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.
	 */
	case GatewayTimeout = 504;

	/**
	 *  The server does not support the HTTP version used in the request.
	 */
	case HTTPVersionNotSupported = 505;

	/**
	 *  Transparent content negotiation for the request results in a circular reference.
	 */
	case VariantAlsoNegotiates = 506;

	/**
	 *  The server is unable to store the representation needed to complete the request.
	 */
	case InsufficientStorage = 507;

	/**
	 *  The server detected an infinite loop while processing the request (sent instead of 208 Already Reported).
	 */
	case LoopDetected = 508;

	/**
	 *  Further extensions to the request are required for the server to fulfil it.
	 */
	case NotExtended = 510;

	/**
	 *  The client needs to authenticate to gain network access.
	 *  Intended for use by intercepting proxies used to control access to the network
	 *  (e.g., "captive portals" used to require agreement to Terms of Service before granting full Internet access via a Wi-Fi hotspot).
	 */
	case NetworkAuthenticationRequired = 511;

	//  ========================== xxx UnOfficial Errors ==========================


}
