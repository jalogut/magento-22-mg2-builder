node {
 	// Clean workspace before doing anything
    deleteDir()

    MAGENTO_DIR='magento'

    try {
        stage ('Clone') {
        	checkout scm
        }
        stage ('Install') {
        	sh "composer install"
        }
        stage ('Tests') {
            sh "bin/mg2-builder tests-setup:install -Dproject.name=${BRANCH_NAME} -Ddatabase.admin.username=${DATABASE_USER} -Ddatabase.admin.password=${DATABASE_PASS} -Ddatabase.user=${DATABASE_USER} -Ddatabase.password=${DATABASE_PASS} -DskipDbUserCreation"
	        parallel 'static': {
	            sh "grumphp run"
	        },
	        'unit': {
	            sh "cd ${MAGENTO_DIR}/dev/tests/unit && ../../../../bin/phpunit -c phpunit.xml"
	        },
	        'integration': {
	            sh "cd ${MAGENTO_DIR}/dev/tests/integration && ../../../../bin/phpunit -c phpunit.xml"
	        },
	        failFast: true
        }
        branchInfo = getBranchInfo()
        if (branchInfo.type == 'develop') {
            stage ('Artifact') {
                sh "bin/mg2-builder artifact:transfer -Dartifact.name=${branchInfo.version} -Dremote.environment=igr -Duse.server.properties"
            }
            stage ('Deploy DEV') {
                 sh "bin/mg2-builder release:deploy -Dremote.environment=igr -Drelease.version=${branchInfo.version} -Ddeploy.build.type=artifact"
            }
        }
        if (branchInfo.type == 'release' || branchInfo.type == 'hotfix') {
            server = confirmServerToDeploy()
            if (server) {
                stage ('TAG VERSION') {
                    sh "git remote set-branches --add origin master && git remote set-branches --add origin develop && git fetch"
                    sh "git checkout master && git checkout develop && git checkout ${BRANCH_NAME}"
                    sh "git flow init -d"
                    //sh "bin/mg2-builder release:finish -Drelease.type=${branchInfo.type} -Drelease.version=${branchInfo.version}"  
                }
                if (server == 'stage' || server == 'both') {
                    stage ('Artifact') {
                        sh "bin/mg2-builder artifact:transfer -Dartifact.name=${branchInfo.version} -Dremote.environment=stage -Duse.server.properties"
                    }
                    stage ('Deploy STAGE') {
                        sh "bin/mg2-builder release:deploy -Dremote.environment=stage -Drelease.version=${branchInfo.version} -Ddeploy.build.type=artifact"
                    }
                }
                if (server == 'production' || server == 'both') {
                    stage ('Artifact') {
                        sh "bin/mg2-builder artifact:transfer -Dartifact.name=${branchInfo.version} -Dremote.environment=prod -Duse.server.properties"
                    }
                    stage ('Deploy PROD') {
                        sh "bin/mg2-builder release:deploy -Dremote.environment=prod -Drelease.version=${branchInfo.version} -Ddeploy.build.type=artifact"
                    }
                }
            }
        }
      	stage ('Clean Up') {
            sh "bin/mg2-builder util:db:clean -Dproject.name=${BRANCH_NAME} -Ddatabase.admin.username=${DATABASE_USER} -Ddatabase.admin.password=${DATABASE_PASS}"
            deleteDir()
        }
    } catch (err) {
        currentBuild.result = 'FAILED'
        // Send email or another notification
        throw err
    }
}

def getBranchInfo() {
    def branchInfo = [:]
    branchData = BRANCH_NAME.split('/')
    if (branchData.size() == 2) {
        branchInfo['type'] = branchData[0]
        branchInfo['version'] = branchData[1]
    } else {
        branchInfo['type'] = BRANCH_NAME
        branchInfo['version'] = BRANCH_NAME
    }
    return branchInfo
}

def confirmServerToDeploy() {
    def server = false
    try {
        timeout(time:2, unit:'HOURS') {
            server = input(
                id: 'environmentInput', message: 'Deployment Settings', parameters: [
                choice(choices: "stage\nproduction\nboth", description: 'Target server to deploy', name: 'deployServer')
            ])
        }
    } catch (err) {
        echo "Timeout expired. Environment was not set by user"
    }
    return server
}