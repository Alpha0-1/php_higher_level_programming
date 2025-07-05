<?php
/**
 * Code Profiling in PHP
 * 
 * Techniques for analyzing code performance and identifying bottlenecks.
 */

class CodeProfiler
{
    private static $timers = [];
    private static $memoryPoints = [];
    
    /**
     * 1. Simple Timer
     */
    public static function startTimer(string $name): void
    {
        self::$timers[$name] = microtime(true);
    }
    
    public static function endTimer(string $name): float
    {
        if (!isset(self::$timers[$name])) {
            throw new InvalidArgumentException("Timer $name not started");
        }
        
        $duration = microtime(true) - self::$timers[$name];
        unset(self::$timers[$name]);
        
        error_log("Timer $name: " . round($duration * 1000, 2) . "ms");
        return $duration;
    }
    
    /**
     * 2. Memory Usage Tracking
     */
    public static function recordMemory(string $point): void
    {
        self::$memoryPoints[$point] = memory_get_usage();
    }
    
    public static function getMemoryReport(): array
    {
        $report = [];
        $previous = null;
        
        foreach (self::$memoryPoints as $point => $memory) {
            $diff = $previous !== null ? $memory - $previous : 0;
            $report[$point] = [
                'memory' => $memory,
                'diff' => $diff
            ];
            $previous = $memory;
        }
        
        return $report;
    }
    
    /**
     * 3. XHProf Integration
     */
    public static function startXhprof(): void
    {
        if (extension_loaded('xhprof')) {
            xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        }
    }
    
    public static function endXhprof(): ?array
    {
        if (extension_loaded('xhprof')) {
            $data = xhprof_disable();
            
            // Include XHProf libraries
            include_once '/path/to/xhprof_lib/utils/xhprof_lib.php';
            include_once '/path/to/xhprof_lib/utils/xhprof_runs.php';
            
            // Save the run
            $xhprofRuns = new XHProfRuns_Default();
            $runId = $xhprofRuns->save_run($data, 'xhprof_test');
            
            return [
                'run_id' => $runId,
                'data' => $data
            ];
        }
        
        return null;
    }
    
    /**
     * 4. Blackfire Integration
     */
    public static function runWithBlackfire(callable $function): void
    {
        if (extension_loaded('blackfire')) {
            $probe = new \Blackfire\Probe();
            $probe->enable();
            
            try {
                $function();
            } finally {
                $probe->disable();
            }
        } else {
            $function();
        }
    }
}

// Usage examples:

// Simple timing
CodeProfiler::startTimer('database_operation');
// ... database operations ...
$duration = CodeProfiler::endTimer('database_operation');

// Memory tracking
CodeProfiler::recordMemory('start');
$largeArray = range(1, 10000);
CodeProfiler::recordMemory('after_array_creation');
$filtered = array_filter($largeArray, fn($x) => $x % 2);
CodeProfiler::recordMemory('after_filtering');

print_r(CodeProfiler::getMemoryReport());

// XHProf profiling
CodeProfiler::startXhprof();
// Code to profile...
$xhprofData = CodeProfiler::endXhprof();

// Blackfire profiling
CodeProfiler::runWithBlackfire(function() {
    // Code to profile
    expensiveOperation();
});

/**
 * Key Takeaways:
 * 1. Always profile before optimizing
 * 2. Measure both time and memory usage
 * 3. Use profiling tools to identify real bottlenecks
 */
?>
