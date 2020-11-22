#include <stdio.h>


char arr[] = "ITAC{Basic_Reverse_but_harder}";

int main(int argc, char *argv[]) {
    for (int i=0; i<19; ++i) {
        printf("%c\n", (arr[i] ^ 0x25));
    }
    puts("");
    return 0;
}
