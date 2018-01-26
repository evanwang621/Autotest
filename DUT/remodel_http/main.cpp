#include <QCoreApplication>
#include "mainhttp.h"

int main(int argc, char *argv[])
{
    QCoreApplication a(argc, argv);
    MainHttp sds;//调用类

    return a.exec();
}
