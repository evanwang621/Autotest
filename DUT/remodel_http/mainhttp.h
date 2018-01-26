#ifndef MAINHTTP_H
#define MAINHTTP_H

#include <QObject>
#include <QtNetwork/QNetworkReply>
#include <QtNetwork/QNetworkRequest>
#include <QtNetwork/QNetworkAccessManager>//包含QNetworkAccessManager类
#include <QtCore>
#include <iostream>

#include <QtNetwork/QNetworkInterface>
#include <QList>

#include <WinSock2.h>
#include <iphlpapi.h>
#include <stdio.h>
#include <stdlib.h>

#include <QtSql/QSqlDatabase>
#include <QtSql/QSqlQuery>
#include <QtSql/QSql>

class MainHttp;
/*
typedef struct getreq{

}getreq;
*/
class MainHttp : public QObject
{
    Q_OBJECT

public:
    MainHttp(QObject *parent = Q_NULLPTR);//构造函数
    ~MainHttp();

    QNetworkAccessManager *manager;
    QNetworkRequest *request;
    QNetworkReply *reply;
    QString url;
    int now_time;
    QString strBuffer;
    QDateTime time;

    QByteArray responseData;
    QEventLoop eventLoop;



    QString getHostMacAddress();
    void getCMD();
    void changeDatabase();



private slots:
    void returnHttp(QNetworkReply*);

};

#endif // MAINHTTP_H
