pipeline {
    agent any

    environment {
        IMAGE_NAME = 'kifansanaufal/todolist-web'
        REGISTRY_CREDENTIALS = 'dockerhub-credentials'
        IMAGE_NAME_WITH_TAG = "${IMAGE_NAME}:${env.BUILD_NUMBER}"
    }

    stages {
        stage('Clean Workspace') {
            steps {
                cleanWs()
            }
        }

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Image') {
            steps {
                script {
                    sh 'echo "Building images for app and webserver..."'
                    sh 'docker-compose build'
                }
            }
        }

        stage('Run Integration Tests') {
            steps {
                script {
                    sh 'echo "Ensuring a clean environment..."'
                    sh 'docker-compose down -v'
                    sh 'echo "Starting containers for testing..."'
                    sh 'docker-compose up -d --no-build'
                    sh 'echo "Waiting for database..."'
                    sh 'sleep 15'
                    sh 'echo "Running migrations..."'
                    sh 'docker-compose exec -T app php artisan migrate'
                    sh 'echo "Running Laravel tests..."'
                    sh 'docker-compose exec -T app php artisan test'
                }
            }
            post {
                always {
                    sh 'echo "Stopping and removing test containers..."'
                    sh 'docker-compose down -v'
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    docker.withRegistry ("https://index.docker.io/v1/", REGISTRY_CREDENTIALS) {
                        sh 'echo "Pushing tag: ${IMAGE_NAME_WITH_TAG}"'
                        sh 'docker push ${IMAGE_NAME_WITH_TAG}'
                        sh 'echo "Tagging and pushing latest"'
                        sh 'docker tag ${IMAGE_NAME_WITH_TAG} ${IMAGE_NAME}:latest'
                        sh 'docker push ${IMAGE_NAME}:latest'
                    }
                }
            }
        }
    }
}
