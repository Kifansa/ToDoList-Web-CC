pipeline {
    agent any

    environment {
        IMAGE_NAME = 'kifansanaufal/todolist-web'
        REGISTRY_CREDENTIALS = 'dockerhub-credentials'
        IMAGE_NAME_WITH_TAG = "${IMAGE_NAME}:${env.BUILD_NUMBER}"
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }


        stage('Build Image') {
            steps {
                script {
                    bat 'echo "Building image: ${IMAGE_NAME_WITH_TAG}"'
                    bat 'docker compose build app'
                }
            }
        }

        stage('Run Integration Tests') {
            steps {
                script {
                    bat 'echo "Starting containers for testing..."'
                    bat 'docker compose up -d --no-build'
                    bat 'echo "Waiting for database..."'
                    bat 'sleep 15'
                    bat 'echo "Running migrations..."'
                    bat 'docker compose exec -T app php artisan migrate'
                    bat 'echo "Running Laravel tests..."'
                    bat 'docker compose exec -T app php artisan test'
                }
            }
            post {
                always {
                    bat 'echo "Stopping and removing test containers..."'
                    bat 'docker compose down -v'
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    docker.withRegistry ("https://index.docker.io/v1/", REGISTRY_CREDENTIALS) {
                        bat 'echo "Pushing tag: ${IMAGE_NAME_WITH_TAG}"'
                        bat 'docker push ${IMAGE_NAME_WITH_TAG}'
                        bat 'echo "Tagging and pushing latest"'
                        bat 'docker tag ${IMAGE_NAME_WITH_TAG} ${IMAGE_NAME}:latest'
                        bat 'docker push ${IMAGE_NAME}:latest'
                    }
                }
            }
        }
    }
}
