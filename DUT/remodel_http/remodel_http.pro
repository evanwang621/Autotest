QT += core
QT -= gui
QT += network
QT += sql

CONFIG += c++11

TARGET = remodel_http
CONFIG += console
CONFIG -= app_bundle

TEMPLATE = app

SOURCES += main.cpp \
    mainhttp.cpp

HEADERS += \
    mainhttp.h
