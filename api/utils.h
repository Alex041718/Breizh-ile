#ifndef UTILS_H
#define UTILS_H

#include <time.h>
#include <stdbool.h>

// Define the log levels
enum log_level {
    INFO,
    WARNING,
    ERROR
};

// Tell if a string is a number
bool is_number(char* str);

// Print a log message
void print_log(const char *message, enum log_level level);

// Replace newlines with spaces
void replace_newlines_with_spaces(char* str);

#endif