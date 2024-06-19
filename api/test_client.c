#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <getopt.h>

// Structure pour les options longues
static struct option long_options[] = {
    {"help", no_argument, NULL, 'h'},
    {"verbose", no_argument, NULL, 'v'},
    {"port", required_argument, NULL, 'p'},
    {NULL, 0, NULL, 0}
};

void print_usage() {
    printf("Usage: synkronizator [options]\n");
    printf("Options:\n");
    printf("  -h, --help\t\tAffiche l'aide\n");
    printf("  -v, --verbose\t\tMode verbeux\n");
    printf("  -p, --port=PORT\tNuméro de port à écouter\n");
}

int main(int argc, char* argv[]) {
    int opt;
    int verbose = 0;
    int port = 0;

    while ((opt = getopt_long(argc, argv, "hvp:", long_options, NULL)) != -1) {
        switch (opt) {
            case 'h':
                print_usage();
                return 0;
            case 'v':
                verbose = 1;
                break;
            case 'p':
                port = atoi(optarg);
                break;
            default:
                print_usage();
                return 1;
        }
    }

    if (port == 0) {
        fprintf(stderr, "Erreur: Le numéro de port est requis\n");
        return 1;
    }

    printf("Mode verbeux: %s\n", verbose ? "Oui" : "Non");
    printf("Port: %d\n", port);

    // Votre code principal ici

    return 0;
}