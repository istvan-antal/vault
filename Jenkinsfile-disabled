properties([disableConcurrentBuilds(), pipelineTriggers([])])

node('php') {
    stage('checkout') {
        checkout scm
    }

    stage('build') {
        sh "make"
    }
}