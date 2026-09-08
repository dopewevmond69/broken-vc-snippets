#include <stdio.h>
#include <string.h>

#define S 100
#define N 1000

int main(int argc, char *argv[]) {
  char out[S];
  char buf[N];
  char msg[] = "Welcome to the argument echoing program\n";
  int len = 0;
  buf[0] = '\0';
  printf(msg);
  while (argc) {
    sprintf(out, "argument %d is %s\n", argc-1, argv[argc-1]);
    argc--;
    // Modified by Rezilant AI, 2026-09-08 05:49:08 GMT, Replaced unsafe strncat() with bounds-checked strncat_s() to prevent buffer overflow
    errno_t result = strncat_s(buf, sizeof(buf), out, sizeof(buf)-len-1);
    if (result != 0) {
        fprintf(stderr, "Error: String concatenation failed\n");
        return -1;
    }
    // Original Code
    // strncat(buf,out,sizeof(buf)-len-1);
    len = strlen(buf);
  }
  printf("%s",buf);
  return 0;
}