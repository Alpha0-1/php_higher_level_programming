# 0x0D - PHP Web Scraping

This project contains a comprehensive collection of PHP scripts designed to teach web scraping concepts, techniques, and best practices. Each file demonstrates different aspects of web scraping, from basic file operations to advanced DOM parsing and API integration.

## Learning Objectives

By the end of this project, you will be able to:

- Understand the fundamentals of web scraping with PHP
- Implement HTTP requests using cURL
- Parse HTML documents using DOMDocument and XPath
- Handle JSON data from APIs
- Implement proper error handling for web scraping
- Apply best practices for respectful web scraping
- Extract structured data from web pages
- Handle pagination in API responses

## Project Structure

### Basic File Operations
- **0-readme.php** - Read file content and display it
- **1-writeme.php** - Write content to a file

### HTTP Requests and API Integration
- **2-statuscode.php** - Make GET requests and retrieve HTTP status codes
- **3-starwars_title.php** - Fetch Star Wars movie titles from SWAPI
- **4-starwars_count.php** - Count character appearances in Star Wars films
- **5-loripsum.php** - Fetch lorem ipsum text from web service
- **6-completed_tasks.php** - Count completed todo items from JSONPlaceholder API

### Advanced Web Scraping
- **100-starwars_characters.php** - List all Star Wars characters with pagination handling
- **101-starwars_movies.php** - List movies by character using API data
- **102-curl_scraper.php** - Advanced cURL scraping techniques
- **103-dom_parser.php** - DOM document parsing and XPath queries

## Prerequisites

- PHP 7.4 or higher
- cURL extension enabled
- DOM extension enabled
- Internet connection for API requests

## Installation

1. Clone this repository:
```bash
git clone <repository-url>
cd 0x0D-php-web_scraping
```

2. Ensure PHP is installed with required extensions:
```bash
php -m | grep -E "(curl|dom|json)"
```

3. Make scripts executable (optional):
```bash
chmod +x *.php
```

## Usage Examples

### Basic Usage
```bash
# Run individual scripts
php 0-readme.php filename.txt
php 1-writeme.php filename.txt "Content to write"
php 2-statuscode.php https://httpbin.org/status/200
```

### API Integration
```bash
# Fetch Star Wars data
php 3-starwars_title.php 1
php 4-starwars_count.php https://swapi.dev/api/films/1/ "Luke Skywalker"
php 100-starwars_characters.php
```

### Advanced Scraping
```bash
# DOM parsing
php 103-dom_parser.php https://httpbin.org/html
php 103-dom_parser.php https://example.com

# Advanced cURL techniques
php 102-curl_scraper.php
```

## Key Concepts Covered

### 1. HTTP Requests with cURL
```php
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Your-Bot-Name/1.0'
]);
$response = curl_exec($curl);
```

### 2. DOM Parsing
```php
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$elements = $xpath->query('//div[@class="content"]');
```

### 3. JSON Handling
```php
$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // Handle JSON errors
}
```

### 4. Error Handling
```php
if (curl_error($curl)) {
    echo "cURL Error: " . curl_error($curl);
}
if ($httpCode !== 200) {
    echo "HTTP Error: $httpCode";
}
```

## Best Practices Demonstrated

### 1. Respectful Scraping
- Implement delays between requests
- Use appropriate User-Agent headers
- Handle rate limiting gracefully
- Respect robots.txt (when applicable)

### 2. Error Handling
- Check for network errors
- Validate HTTP status codes
- Handle JSON parsing errors
- Implement fallback mechanisms

### 3. Data Validation
- Sanitize input data
- Validate URLs before requests
- Check for required fields
- Handle empty or malformed responses

### 4. Performance Optimization
- Use efficient parsing methods
- Implement caching when appropriate
- Handle large datasets properly
- Optimize memory usage

## Common Use Cases

### Web Data Extraction
- Extract product information from e-commerce sites
- Gather news articles and metadata
- Collect social media posts
- Monitor price changes

### API Integration
- Fetch data from REST APIs
- Handle paginated responses
- Process JSON/XML data
- Implement authentication

### Content Monitoring
- Track website changes
- Monitor competitor content
- Collect SEO data
- Gather contact information

## Security Considerations

### Input Validation
- Always validate URLs before making requests
- Sanitize user input
- Check file permissions before writing
- Validate JSON data structure

### Rate Limiting
- Implement delays between requests
- Use exponential backoff for retries
- Monitor API usage limits
- Respect server resources

### Error Handling
- Never expose sensitive information in error messages
- Log errors appropriately
- Implement proper timeout handling
- Handle SSL certificate issues

## Troubleshooting

### Common Issues

1. **cURL errors**: Check internet connection and SSL certificates
2. **JSON parsing errors**: Validate API response format
3. **DOM parsing issues**: Handle malformed HTML gracefully
4. **HTTP errors**: Implement proper status code handling

### Debug Tips
```php
// Enable cURL verbose output
curl_setopt($curl, CURLOPT_VERBOSE, true);

// Check for libxml errors
$errors = libxml_get_errors();
foreach ($errors as $error) {
    echo "XML Error: " . $error->message;
}
```

## API References

### Star Wars API (SWAPI)
- Base URL: https://swapi.dev/api/
- Endpoints: people, films, starships, vehicles, species, planets
- Documentation: https://swapi.dev/documentation

### JSONPlaceholder
- Base URL: https://jsonplaceholder.typicode.com/
- Endpoints: posts, comments, albums, photos, todos, users
- Documentation: https://jsonplaceholder.typicode.com/guide/

## Contributing

1. Fork the repository
2. Create a feature branch
3. Follow the coding standards demonstrated in existing files
4. Add appropriate documentation and comments
5. Test your changes thoroughly
6. Submit a pull request

## Code Style Guidelines

- Use descriptive variable names
- Include comprehensive error handling
- Add educational comments explaining concepts
- Follow PHP PSR standards where applicable
- Include usage examples in comments

## Resources for Further Learning

### Documentation
- [PHP cURL Documentation](https://www.php.net/manual/en/book.curl.php)
- [DOMDocument Documentation](https://www.php.net/manual/en/class.domdocument.php)
- [XPath Tutorial](https://www.w3schools.com/xml/xpath_intro.asp)

### Best Practices
- [Web Scraping Ethics](https://blog.apify.com/web-scraping-ethics/)
- [Respectful Web Scraping](https://www.scrapehero.com/web-scraping-ethics/)
- [HTTP Status Codes](https://httpstatuses.com/)

### Tools and Libraries
- [Guzzle HTTP Client](https://docs.guzzlephp.org/)
- [Simple HTML DOM Parser](https://sourceforge.net/projects/simplehtmldom/)
- [Goutte Web Scraper](https://github.com/FriendsOfPHP/Goutte)

## License

This project is created for educational purposes. Please respect the terms of service of any websites or APIs you scrape.

## Disclaimer

This project is for educational purposes only. Always respect robots.txt files, terms of service, and applicable laws when scraping websites. The authors are not responsible for any misuse of the techniques demonstrated in this project.

---

**Note**: Always test your scraping scripts responsibly and ensure you comply with the target website's terms of service and legal requirements.
