<?php
/**
 * 103-dom_parser.php
 * 
 * This script demonstrates advanced DOM parsing techniques using PHP's
 * DOMDocument and DOMXPath classes. It shows how to extract structured
 * data from HTML documents fetched from the web.
 * 
 * Learning Objectives:
 * - Understanding DOM manipulation in PHP
 * - XPath query usage for precise element selection
 * - HTML parsing and data extraction
 * - Error handling for malformed HTML
 * - Practical web scraping implementation
 * 
 * Usage: php 103-dom_parser.php [URL]
 * Example: php 103-dom_parser.php https://httpbin.org/html
 */

/**
 * HTMLScraper class demonstrates comprehensive DOM parsing techniques
 * 
 * This class encapsulates various methods for fetching and parsing HTML
 * content, showcasing best practices for web scraping.
 */
class HTMLScraper {
    
    private $dom;
    private $xpath;
    
    /**
     * Constructor initializes DOM parser with error handling
     */
    public function __construct() {
        $this->dom = new DOMDocument();
        
        // Suppress HTML parsing warnings for malformed HTML
        libxml_use_internal_errors(true);
    }
    
    /**
     * Fetches HTML content from a given URL
     * 
     * @param string $url The URL to fetch
     * @return string|false HTML content or false on failure
     */
    public function fetchHTML($url) {
        // Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            echo "Error: Invalid URL format\n";
            return false;
        }
        
        // Initialize cURL for robust HTTP requests
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP-DOM-Parser/1.0)',
            CURLOPT_SSL_VERIFYPEER => false, // For educational purposes
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.5',
                'Accept-Encoding: gzip, deflate',
                'Connection: keep-alive',
            ],
        ]);
        
        $html = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        // Handle cURL errors
        if ($error) {
            echo "cURL Error: $error\n";
            return false;
        }
        
        // Handle HTTP errors
        if ($httpCode < 200 || $httpCode >= 300) {
            echo "HTTP Error: Status code $httpCode\n";
            return false;
        }
        
        return $html;
    }
    
    /**
     * Loads HTML content into DOM parser
     * 
     * @param string $html HTML content to parse
     * @return bool Success status
     */
    public function loadHTML($html) {
        if (empty($html)) {
            echo "Error: Empty HTML content\n";
            return false;
        }
        
        // Load HTML with encoding handling
        $success = $this->dom->loadHTML(
            '<?xml encoding="UTF-8">' . $html,
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        
        if (!$success) {
            echo "Error: Failed to parse HTML\n";
            return false;
        }
        
        // Initialize XPath for advanced querying
        $this->xpath = new DOMXPath($this->dom);
        
        return true;
    }
    
    /**
     * Extracts all links from the document
     * 
     * @return array Array of link information
     */
    public function extractLinks() {
        $links = [];
        
        // Use XPath to find all anchor tags with href attributes
        $anchors = $this->xpath->query('//a[@href]');
        
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $text = trim($anchor->textContent);
            $title = $anchor->getAttribute('title');
            
            $links[] = [
                'url' => $href,
                'text' => $text,
                'title' => $title,
                'is_external' => $this->isExternalLink($href)
            ];
        }
        
        return $links;
    }
    
    /**
     * Extracts all images from the document
     * 
     * @return array Array of image information
     */
    public function extractImages() {
        $images = [];
        
        // Find all img tags
        $imgTags = $this->xpath->query('//img[@src]');
        
        foreach ($imgTags as $img) {
            $src = $img->getAttribute('src');
            $alt = $img->getAttribute('alt');
            $title = $img->getAttribute('title');
            $width = $img->getAttribute('width');
            $height = $img->getAttribute('height');
            
            $images[] = [
                'src' => $src,
                'alt' => $alt,
                'title' => $title,
                'width' => $width,
                'height' => $height
            ];
        }
        
        return $images;
    }
    
    /**
     * Extracts all headings (h1-h6) from the document
     * 
     * @return array Array of heading information
     */
    public function extractHeadings() {
        $headings = [];
        
        // Find all heading tags
        $headingTags = $this->xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');
        
        foreach ($headingTags as $heading) {
            $level = intval(substr($heading->nodeName, 1));
            $text = trim($heading->textContent);
            $id = $heading->getAttribute('id');
            
            $headings[] = [
                'level' => $level,
                'text' => $text,
                'id' => $id,
                'tag' => $heading->nodeName
            ];
        }
        
        return $headings;
    }
    
    /**
     * Extracts metadata from the document
     * 
     * @return array Array of metadata information
     */
    public function extractMetadata() {
        $metadata = [];
        
        // Extract title
        $titleNodes = $this->xpath->query('//title');
        $metadata['title'] = $titleNodes->length > 0 ? trim($titleNodes->item(0)->textContent) : '';
        
        // Extract meta tags
        $metaTags = $this->xpath->query('//meta[@name or @property]');
        
        foreach ($metaTags as $meta) {
            $name = $meta->getAttribute('name') ?: $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            
            if ($name && $content) {
                $metadata['meta'][$name] = $content;
            }
        }
        
        return $metadata;
    }
    
    /**
     * Custom content extraction using XPath
     * 
     * @param string $xpath XPath expression
     * @return array Array of matching elements
     */
    public function extractByXPath($xpath) {
        $results = [];
        
        try {
            $nodes = $this->xpath->query($xpath);
            
            foreach ($nodes as $node) {
                $results[] = [
                    'tag' => $node->nodeName,
                    'text' => trim($node->textContent),
                    'html' => $this->dom->saveHTML($node),
                    'attributes' => $this->getNodeAttributes($node)
                ];
            }
        } catch (Exception $e) {
            echo "XPath Error: " . $e->getMessage() . "\n";
        }
        
        return $results;
    }
    
    /**
     * Helper method to extract all attributes from a node
     * 
     * @param DOMNode $node The node to extract attributes from
     * @return array Array of attributes
     */
    private function getNodeAttributes($node) {
        $attributes = [];
        
        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $attributes[$attr->nodeName] = $attr->nodeValue;
            }
        }
        
        return $attributes;
    }
    
    /**
     * Determines if a link is external
     * 
     * @param string $href The link URL
     * @return bool True if external, false otherwise
     */
    private function isExternalLink($href) {
        // Simple check for external links
        return strpos($href, 'http://') === 0 || strpos($href, 'https://') === 0;
    }
    
    /**
     * Displays extracted data in a formatted way
     * 
     * @param array $data The data to display
     * @param string $title Title for the section
     */
    public function displayData($data, $title) {
        echo "\n=== $title ===\n";
        
        if (empty($data)) {
            echo "No data found.\n";
            return;
        }
        
        foreach ($data as $index => $item) {
            echo "[" . ($index + 1) . "] ";
            
            if (is_array($item)) {
                foreach ($item as $key => $value) {
                    if (is_array($value)) {
                        echo "$key: " . json_encode($value) . "\n    ";
                    } else {
                        echo "$key: $value\n    ";
                    }
                }
            } else {
                echo $item;
            }
            
            echo "\n";
        }
    }
}

/**
 * Demonstrates various DOM parsing techniques
 * 
 * @param string $url URL to scrape
 */
function demonstrateDOMParsing($url) {
    echo "=== DOM PARSING DEMONSTRATION ===\n";
    echo "Target URL: $url\n\n";
    
    // Create scraper instance
    $scraper = new HTMLScraper();
    
    // Fetch HTML content
    echo "Fetching HTML content...\n";
    $html = $scraper->fetchHTML($url);
    
    if ($html === false) {
        echo "Failed to fetch HTML content.\n";
        return;
    }
    
    // Load HTML into DOM parser
    echo "Parsing HTML content...\n";
    if (!$scraper->loadHTML($html)) {
        echo "Failed to parse HTML content.\n";
        return;
    }
    
    // Extract various elements
    echo "Extracting page elements...\n";
    
    // Extract and display metadata
    $metadata = $scraper->extractMetadata();
    echo "\n=== PAGE METADATA ===\n";
    echo "Title: " . ($metadata['title'] ?: 'No title found') . "\n";
    
    if (isset($metadata['meta'])) {
        echo "Meta tags:\n";
        foreach ($metadata['meta'] as $name => $content) {
            echo "  $name: $content\n";
        }
    }
    
    // Extract and display headings
    $headings = $scraper->extractHeadings();
    $scraper->displayData($headings, "HEADINGS");
    
    // Extract and display links
    $links = $scraper->extractLinks();
    $scraper->displayData($links, "LINKS");
    
    // Extract and display images
    $images = $scraper->extractImages();
    $scraper->displayData($images, "IMAGES");
    
    // Demonstrate custom XPath extraction
    echo "\n=== CUSTOM XPATH EXAMPLES ===\n";
    
    // Extract all paragraphs
    $paragraphs = $scraper->extractByXPath('//p');
    echo "Found " . count($paragraphs) . " paragraphs\n";
    
    // Extract elements with specific classes (example)
    $specificElements = $scraper->extractByXPath('//*[@class="highlight"]');
    echo "Found " . count($specificElements) . " elements with class 'highlight'\n";
    
    // Extract all text from div elements
    $divTexts = $scraper->extractByXPath('//div');
    echo "Found " . count($divTexts) . " div elements\n";
}

/**
 * Main execution function
 */
function main() {
    global $argv;
    
    // Default URL for demonstration
    $defaultUrl = "https://httpbin.org/html";
    
    // Get URL from command line argument or use default
    $url = isset($argv[1]) ? $argv[1] : $defaultUrl;
    
    echo "PHP DOM Parser Demonstration\n";
    echo "============================\n";
    
    if ($url === $defaultUrl) {
        echo "Using default URL. You can specify a custom URL as an argument.\n";
        echo "Usage: php 103-dom_parser.php [URL]\n";
    }
    
    // Demonstrate DOM parsing
    demonstrateDOMParsing($url);
    
    echo "\n=== EDUCATIONAL SUMMARY ===\n";
    echo "This script demonstrated:\n";
    echo "1. Fetching HTML content with cURL\n";
    echo "2. Parsing HTML with DOMDocument\n";
    echo "3. Using XPath for precise element selection\n";
    echo "4. Extracting various types of content\n";
    echo "5. Error handling for robust scraping\n";
    echo "6. Structured data organization\n";
}

// Execute main function if script is run directly
if (php_sapi_name() === 'cli') {
    main();
} else {
    // For web execution
    header('Content-Type: text/plain');
    main();
}

/*
 * NOTES:
 * 
 * 1. DOMDocument vs SimpleXML: DOMDocument is more powerful for complex
 *    HTML parsing, while SimpleXML is better for well-formed XML.
 * 
 * 2. XPath Expressions: XPath provides powerful querying capabilities:
 *    - //tag : All elements with tag name
 *    - //tag[@attr] : Elements with specific attribute
 *    - //tag[position()=1] : First occurrence of tag
 *    - //tag[contains(@class, 'name')] : Elements containing class
 * 
 * 3. Error Handling: Always handle parsing errors gracefully, especially
 *    when dealing with malformed HTML from the web.
 * 
 * 4. Memory Management: For large documents, consider using DOMDocument's
 *    streaming capabilities or processing in chunks.
 * 
 * 5. Character Encoding: Always specify UTF-8 encoding to handle
 *    international characters correctly.
 * 
 * ADVANCED TECHNIQUES:
 * - Use DOMXPath for complex queries
 * - Implement caching for frequently accessed pages
 * - Handle JavaScript-rendered content with headless browsers
 * - Implement rate limiting for respectful scraping
 * 
 * COMMON PITFALLS:
 * - Not handling malformed HTML
 * - Ignoring character encoding issues
 * - Not validating extracted data
 * - Overwhelming servers with too many requests
 */
?>
