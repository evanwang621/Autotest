#include "mainhttp.h"
#include <QTime>
MainHttp::MainHttp(QObject *parent):QObject(parent)//继承QObject类：会把MainHttp类存入list中
{

    manager = new QNetworkAccessManager();
    request = new QNetworkRequest();


    //获取MAC地址
    QString MACaddr = getHostMacAddress();

    while(1){
        //获取时间
        time = QDateTime::currentDateTime();
        now_time = time.toTime_t();//获取时间戳
        strBuffer = QString::number(now_time, 10);//int转QString
        //qDebug()<<QString(strBuffer);
        //strBuffer = time.toString("yyyy-MM-dd hh:mm:ss");//日期型时间QString

        //get配置

        //url = "http://169.254.136.1:8010/posts/test/11/10";
        url = "http://169.254.136.1:8010/posts/test/"+MACaddr+"/"+strBuffer;
        //url= "http://www.runoob.com/try/ajax/demo_get.php";
        //url = "http://169.254.136.1:8010/task";
        request->setUrl(QUrl(url));
        reply = manager->get(*request);

        //connect(manager, SIGNAL(finished(QNetworkReply*)), this, SLOT(returnHttp(QNetworkReply*)));//信号槽

        connect(manager, SIGNAL(finished(QNetworkReply*)), &eventLoop, SLOT(quit()));//信号槽
        eventLoop.exec();       //block until finish
        responseData = reply->readAll();//读取返回数据
        qDebug()<<QString(responseData);
        reply->close();//没发现效果

        Sleep(2000);//单位为ms

   }

    //changeDatabase();
}
MainHttp::~MainHttp()
{
    if(manager != NULL && request != NULL)
    {
        delete []manager;
        delete []request;
    }
}

void MainHttp::returnHttp(QNetworkReply *qreply)
{
    if(qreply && qreply->error() == QNetworkReply::NoError)
    {
        responseData = qreply->readAll();//读取返回数据
        qDebug()<<QString(responseData);
    }
    else
    {
        qDebug()<<qreply->errorString();
    }
    qreply->close();
}
//
QString MainHttp::getHostMacAddress()
{
    QList<QNetworkInterface> nets = QNetworkInterface::allInterfaces();// 获取所有网络接口列表
    int nCnt = nets.count();
//    qDebug()<<nCnt;
    QString strMacAddr = "";
    for(int i = 0; i < nCnt; i ++)
    {
        // 如果此网络接口被激活并且正在运行并且不是回环地址，则就是我们需要找的Mac地址
        if(nets[i].flags().testFlag(QNetworkInterface::IsUp) && nets[i].flags().testFlag(QNetworkInterface::IsRunning) && !nets[i].flags().testFlag(QNetworkInterface::IsLoopBack))
        {
            strMacAddr = nets[i].hardwareAddress();
            break;
        }
    }
    return strMacAddr;
}

void MainHttp::getCMD()
{
    /*
    QProcess p(0);
    p.start("ipconfig");
    p.waitForStarted();
    p.waitForFinished();
    qDebug()<<QString::fromLocal8Bit(p.readAllStandardError());
    */
    //QProcess *po = new QProcess(this);
    //po->start("vlc.exe");
    system("vlc.exe");
}

//数据库操作
void MainHttp::changeDatabase()
{
    /*//检查驱动
    QStringList drives = QSqlDatabase::drivers();
    qDebug()<<drives;
    */
    QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");//参数是使用的什么数据库
    db.setHostName("169.254.136.1");//数据库所在位置
    db.setPort(8010);//数据库端口编号
    db.setDatabaseName("test");//数据库名
    db.setUserName("root");//用户名
    db.setPassword("12345678");//密码
    if(!db.open())
    {
        qDebug("Cannot open database!");
    }
    QSqlQuery query;
    query.exec("select * from boardstatus");
    while(query.next())
    {
        int id = query.value(0).toInt();
        QString macAddr = query.value(1).toString();
        qDebug()<<id<<"|"<<macAddr;
    }
    db.close();

}
