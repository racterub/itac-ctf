#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {
    seteuid(0);
    setegid(0);
    setuid(0);
    setgid(0);

    system("/bin/cat /flag");
    return 0;
}
