#include <stdio.h>
#include <stdlib.h>
int main(int argc, char *argv[]) {
    int q;
    printf("Guess a Number: ");
    scanf("%d", &q);
    if (q == 859382844) {
        system("cat .passwd");
    } else {
        puts("you are a bad guesser");
    }
    return 0;
}
