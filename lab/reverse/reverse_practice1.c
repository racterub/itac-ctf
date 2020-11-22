#include <stdio.h>

int arr[] = {48, 46, 52, 10, 47, 39, 114, 24, 29, 42, 32, 39, 30, 59, 73, 8, 16, 45, 11, 54, 42, 13, 18, 42, 34, 49, 56, 28, 0, 0, 0, 0, 0, 0, 0, 4};
char key[] = "yzuITAC";
int main(int argc, char *argv[]) {
    int arrLen = sizeof(arr) / sizeof(int);
    printf("Encrypted Flag: ");
    for (int i=0; i<arrLen; i++) {
        printf("%c", arr[i]);
    }
    puts("");
    return 0;
}
